<?php

namespace App\Http\Controllers;

use App\Exports\ExportSalaries;
use App\Http\Requests\StoreGajiKaryawanRequest;
use App\Imports\ImportSalaries;
use Yajra\DataTables\DataTables;
use App\Models\Departemen;
use App\Models\employee;
use App\Models\fileSalary;
use App\Models\GajiKaryawan;
use App\Models\salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class SalaryController extends Controller
{
    public $start;

    public function index()
    {
        return view('payslip.index');
    }

    public function payslip(Request $request)
    {
        if ($request->filled('period')) {

            $start = $request->period . '-16';
            $datas = salary::orderBy('employee_id', 'desc')->whereDate('mulai_periode', $start)->get();

            return view('payslip.slipgaji', compact('datas'));
        } else {
            $datas = [];
        }
        return view('payslip.slipgaji', compact('datas'));
    }

    public function printPayslip($id)
    {
        $data = salary::with('employee')->where('id', $id)->first();
        $total_deduction = $data->jht + $data->jp + $data->bpjs_kesehatan + $data->deduction_unpaid_leave + $data->deduction_php21;
        $total_diterima = ($data->gaji_pokok + $data->tunjangan_umum + $data->tunjangan_pengawas + $data->tunjangan_transport + $data->tunjangan_mk + $data->tunjangan_koefisien + $data->rapel + $data->insentif + $data->tunjangan_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        return view('payslip.payslip-print', compact('data', 'total_diterima', 'total_deduction', 'gaji_bersih'));
    }

    public function gajiKaryawan(Request $request)
    {
        $karyawan = employee::select('nik', 'nama_karyawan')->get();
        $departement = Departemen::all();

        return view('payslip.gaji-karyawan', compact('karyawan', 'departement'));
    }

    public function serverSideSalary(Request $request)
    {
        $data = employee::join('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->join('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->join('gaji_karyawan', 'gaji_karyawan.nik_karyawan', '=', 'employees.nik');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('payslip._action', [
                    'data' => $data,
                    'url_show' => route('salary.show', $data->nik),
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->get('departemen') != '') {
                    $instance->where('departemen_id', $request->get('departemen'));
                }
                if ($request->get('nama_divisi') != '') {
                    $instance->where('divisi_id', $request->get('nama_divisi'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('nik', 'LIKE', "%$search%")
                            ->orWhere('nama_karyawan', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createSalary()
    {
        return view('/payslip/create-gaji-karyawan');
    }

    public function show(Request $request, $id)
    {
        $data = gajiKaryawan::with('employee')->where('nik_karyawan', $id)->first();

        $leave = [];
        $salary = [];
        $absensis = [];

        if ($request->filled('period')) {
            $start = $request->period . '-16';
            $end = date('Y-m-d', strtotime("$start +1 Month -1 Day"));

            $salaries = employee::with([
                'gajiKaryawan',
                'cutiIzin' => function ($query) use ($start, $end) {
                    $query->whereBetween('tanggal_mulai', [$start, $end]);
                },
                'absensi' => function ($query) use ($start, $end) {
                    $query->whereBetween('jam_masuk', [$start . " 00:00:00", $end . " 23:59:59"]);
                }
            ])->where('nik', $id)->first();



            foreach ($salaries->cutiIzin as $row) {

                $leave[] = $row;
            }

            foreach ($salaries->absensi as $row) {

                $absensis[] = $row;
            }

            $daily_salary = dailySalary($data, $absensis);

            $meal_allowance = mealAllowance($data, $absensis);

            $jht = $data->gaji_pokok * 0.02;

            $jp = $data->gaji_pokok * 0.01;

            $bpjs_kesehatan = $data->gaji_pokok * 0.01;

            $deduction_unpaid_leave = 0;

            $deduction_pph21 = 0;

            $total_deduction = $jht + $jp + $bpjs_kesehatan + $deduction_unpaid_leave + $deduction_pph21;

            $total_diterima = $daily_salary + $data->tunj_umum + $data->tunj_pengawas + $data->tunj_transport_pulsa + $data->tunj_masa_kerja + $data->tunj_koefisien_jabatan + $data->tunj_lap + $meal_allowance;

            $gaji_bersih = $total_diterima - $total_deduction;

            $data = [
                'salary' => $data,
                'employee' => $data->employee,
                'jht' => $jht,
                'jp' => $jp,
                'bpjs_kesehatan' => $bpjs_kesehatan,
                'daily_salary' => $daily_salary,
                'meal_allowance' => $meal_allowance,
                'deduction_unpaid_leave' => $deduction_unpaid_leave,
                'deduction_pph21' => $deduction_pph21,
                'total_deduction' => $total_deduction,
                'total_diterima' => $total_diterima,
                'gaji_bersih' => $gaji_bersih,
            ];

            return view('payslip.show', compact('data', 'absensis', 'start', 'end'));
        }

        $current_month = date('Y-m', strtotime(Carbon::now()));

        $start = $current_month . '-16';
        $start = date('Y-m-d', strtotime("$start -1 Month -1 Day"));
        $end = date('Y-m-d', strtotime("$start +1 Month +1 Day"));

        $salaries = employee::with([
            'gajiKaryawan',
            'cutiIzin' => function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            },
            'absensi' => function ($query) use ($start, $end) {
                $query->whereBetween('jam_masuk', [$start . " 00:00:00", $end . " 23:59:59"]);
            }
        ])->where('nik', $id)->first();


        foreach ($salaries->cutiIzin as $row) {

            $leave[] = $row;
        }

        foreach ($salaries->absensi as $row) {

            $absensis[] = $row;
        }

        $daily_salary = dailySalary($data, $absensis);

        $meal_allowance = mealAllowance($data, $absensis);

        $jht = $data->gaji_pokok * 0.02;

        $jp = $data->gaji_pokok * 0.01;

        $bpjs_kesehatan = $data->gaji_pokok * 0.01;

        $deduction_unpaid_leave = 0;

        $deduction_pph21 = 0;

        $total_deduction = $jht + $jp + $bpjs_kesehatan + $deduction_unpaid_leave + $deduction_pph21;

        $total_diterima = $daily_salary + $data->tunj_umum + $data->tunj_pengawas + $data->tunj_transport_pulsa + $data->tunj_masa_kerja + $data->tunj_koefisien_jabatan + $data->tunj_lap + $meal_allowance;

        $gaji_bersih = $total_diterima - $total_deduction;

        $data = [
            'salary' => $data,
            'employee' => $data->employee,
            'jht' => $jht,
            'jp' => $jp,
            'bpjs_kesehatan' => $bpjs_kesehatan,
            'daily_salary' => $daily_salary,
            'meal_allowance' => $meal_allowance,
            'deduction_unpaid_leave' => $deduction_unpaid_leave,
            'deduction_pph21' => $deduction_pph21,
            'total_deduction' => $total_deduction,
            'total_diterima' => $total_diterima,
            'gaji_bersih' => $gaji_bersih,
        ];
        return view('payslip.show', compact('data', 'absensis', 'start', 'end'));
    }

    public function generateSlip(Request $request, $nik)
    {
        $data = gajiKaryawan::with('employee')->where('nik_karyawan', $nik)->first();

        $leave = [];
        $absensis = [];
        $start = $request->period . '-16';
        $end = date('Y-m-d', strtotime("$start +1 Month -1 Day"));

        $salaries = employee::with([
            'gajiKaryawan',
            'cutiIzin' => function ($query) use ($start, $end) {
                $query->whereBetween('tanggal_mulai', [$start, $end]);
            },
            'absensi' => function ($query) use ($start, $end) {
                $query->whereBetween('jam_masuk', [$start . " 00:00:00", $end . " 23:59:59"]);
            }
        ])->where('nik', $nik)->first();

        foreach ($salaries->cutiIzin as $row) {
            $leave[] = $row;
        }

        foreach ($salaries->absensi as $row) {
            $absensis[] = $row;
        }

        $daily_salary = dailySalary($data, $absensis);
        $meal_allowance = mealAllowance($data, $absensis);
        $jht = $data->gaji_pokok * 0.02;
        $jp = $data->gaji_pokok * 0.01;
        $bpjs_kesehatan = $data->gaji_pokok * 0.01;
        $deduction_unpaid_leave = 0;
        $deduction_pph21 = 0;
        $total_deduction = $jht + $jp + $bpjs_kesehatan + $deduction_unpaid_leave + $deduction_pph21;
        $total_diterima = $daily_salary + $data->tunj_umum + $data->tunj_pengawas + $data->tunj_transport_pulsa + $data->tunj_masa_kerja + $data->tunj_koefisien_jabatan + $data->tunj_lap + $meal_allowance;
        $gaji_bersih = $total_diterima - $total_deduction;

        $data = [
            'salary' => $data,
            'employee' => $data->employee,
            'jht' => $jht,
            'jp' => $jp,
            'bpjs_kesehatan' => $bpjs_kesehatan,
            'daily_salary' => $daily_salary,
            'meal_allowance' => $meal_allowance,
            'deduction_unpaid_leave' => $deduction_unpaid_leave,
            'deduction_pph21' => $deduction_pph21,
            'total_deduction' => $total_deduction,
            'total_diterima' => $total_diterima,
            'gaji_bersih' => $gaji_bersih,
        ];

        try {
            DB::beginTransaction();
            salary::create([
                'id' => Uuid::uuid4()->getHex(),
                'employee_id' => $data['salary']['nik_karyawan'],
                'posisi' => $data['employee']['posisi'],
                'durasi_sp' => '2015-01-01' ?? null,
                'status_gaji' => $data['salary']['status_gaji'],
                'jumlah_hari_kerja' => count($absensis),
                'jumlah_hour_machine' => 0,
                'gaji_pokok' => $data['daily_salary'],
                'tunjangan_umum' => $data['salary']['tunj_umum'],
                'tunjangan_pengawas' => $data['salary']['tunj_pengawas'],
                'tunjangan_transport' => $data['salary']['tunj_transport_pulsa'],
                'tunjangan_mk' => $data['salary']['tunj_masa_kerja'],
                'tunjangan_koefisien' => $data['salary']['tunj_koefisien_jabatan'],
                'ot' => 0,
                'hm' => 0,
                'rapel' => 0,
                'insentif' => 0,
                'tunjangan_lap' => 0,
                'bonus' => 0,
                'jht' => $data['jht'],
                'jp' => $data['jp'],
                'bpjs_kesehatan' => $data['bpjs_kesehatan'],
                'unpaid_leave' => $data['deduction_unpaid_leave'],
                'deduction' => 0,
                'total_diterima' => $data['gaji_bersih'],
                'account_number' => $data['employee']['no_rekening'],
                'bank' => $data['employee']['nama_bank'],
                'mulai_periode' => $start,
                'akhir_periode' => $end,
                'deduction_pph21' => $data['deduction_pph21'],
                'thr' => 0,
                'note' => 'Test',
                'created_by' => Auth::user()->nik_karyawan
            ]);
            DB::commit();
            return back()->with('success', 'Generate success');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Generate failed');
        }
    }


    public function storeGajiKaryawan(Request $request)
    {
        GajiKaryawan::updateOrCreate([
            'nik_karyawan' => $request->nik_karyawan,
        ], [
            'status_gaji' => $request->status_gaji,
            'jumlah_hari_kerja' => $request->jumlah_hari_kerja,
            'tunj_umum' => $request->tunj_umum ?? 0,
            'tunj_pengawas' => $request->tunj_pengawas ?? 0,
            'tunj_transport_pulsa' => $request->tunj_transport_pulsa ?? 0,
            'tunj_masa_kerja' => $request->tunj_masa_kerja ?? 0,
            'tunj_koefisien_jabatan' => $request->tunj_koefisien_jabatan ?? 0,
            'tunj_lap' => $request->tunj_lap ?? 0,
            'tunj_makan' => str_replace(array('Rp', '.'), "", $request->tunj_makan),
            'gaji_pokok' => str_replace(array('Rp', '.'), "", $request->gaji_pokok)
        ]);

        return back()->with('success', 'Penyesuaian gaji NIK : ' . $request->nik . ' berhasil dilakukan');
    }

    public function history()
    {
        $datas = fileSalary::orderBy('id', 'DESC')->limit(100)->get();
        return view('payslip.history', compact('datas'))->with('no');
    }



    public function downloadSalaryComponent($id)
    {
        $data = fileSalary::where('id', $id)->first();
        return response()->download(public_path('salaries/' . $data->path));
    }

    public function importSalary(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $file_name = $file->getClientOriginalName();
            $file->move('salaries', $file_name);
            $path = $file_name;

            DB::beginTransaction();
            fileSalary::create([
                'user_id' => Auth::user()->employee_id,
                'path' => $path
            ]);
            Excel::import(new ImportSalaries, public_path('/salaries/' . $file_name));
            DB::commit();
            return back()->with('success', 'Salaries has been uploaded');
        }
    }

    public function exportSalary(Request $request)
    {
        return Excel::download(new ExportSalaries, 'Salary-Template.xlsx');
    }
}

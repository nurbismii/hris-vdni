<?php

namespace App\Http\Controllers;

use App\Exports\ExportSalaries;
use App\Http\Requests\StoreGajiKaryawanRequest;
use App\Imports\ImportSalaries;
use App\Models\Absensi;
use App\Models\employee;
use App\Models\fileSalary;
use App\Models\GajiKaryawan;
use App\Models\salary;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SalaryController extends Controller
{
    public $start;

    public function index()
    {
        return view('payslip.index');
    }

    public function slipgaji(Request $request)
    {
        $start = '2023-08'. '-16';
        $end = date('Y-m-d', strtotime("$start +1 Month -1 Day"));

        $datas = employee::with(['absensi' => function ($query) use ($start, $end){
            $query->whereBetween('jam_masuk', [$start . " 00:00:00", $end . " 23:59:59"]);
        }])->where('nik', '15040001')->get();

        return $datas;

        return view('payslip.slipgaji', compact('datas'));
    }

    public function show($id)
    {
        $data = salary::findOrFail($id);
        $total_deduction = $data->jht + $data->jp + $data->bpjs_kesehatan + $data->deduction_unpaid_leave + $data->deduction_php21;
        $total_diterima = ($data->gaji_pokok + $data->tunjangan_umum + $data->tunjangan_pengawas + $data->tunjangan_transport + $data->tunjangan_mk + $data->tunjangan_koefisien + $data->rapel + $data->insentif + $data->tunjangan_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        return view('payslip.show', compact('data', 'total_diterima', 'total_deduction', 'gaji_bersih'));
    }

    public function history()
    {
        $datas = fileSalary::orderBy('id', 'DESC')->limit(100)->get();
        return view('payslip.history', compact('datas'))->with('no');
    }

    public function importSalary(Request $request)
    {
        if ($request->hasFile('file')) {
            $current_time = date('Y-m-d', strtotime(Carbon::now()));
            $file = $request->file('file');
            $file_name = 'KOMPONEN GAJI (' . $current_time . ')' . '.' . $file->getClientOriginalExtension();
            $file->move('salaries', $file_name);
            $path = 'public/salaries/' . $file_name;

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

    public function gajiKaryawan()
    {
        $karyawan = employee::select('nik', 'nama_karyawan')->orderBy('nik', 'ASC')->get();
        return view('payslip.gaji-karyawan', compact('karyawan'));
    }

    public function fetchDetailKaryawan($nik)
    {
        $data = employee::leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->select(DB::raw("*"))
            ->where('employees.nik', $nik)->first();
        return response()->json($data);
    }

    public function storeGajiKaryawan(StoreGajiKaryawanRequest $request)
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
}

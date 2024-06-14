<?php

namespace App\Http\Controllers;

use Yajra\DataTables\DataTables;
use App\Models\Departemen;
use App\Models\employee;
use App\Models\fileSalary;
use App\Models\salary;
use PDF;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $req_date = salary::select('mulai_periode', 'akhir_periode')->whereDate('mulai_periode', $start)->first();

            return view('payslip.slipgaji', compact('datas', 'req_date'));
        } else {
            $datas = [];
            $req_date = '';
        }
        return view('payslip.slipgaji', compact('datas', 'req_date'));
    }

    public function printPayslip($id)
    {
        $now = new DateTime();
        $now->modify('-1 month');
        $previousMonth = $now->format('Y-m');

        $data = DB::connection('epayslip')
            ->table('data_karyawans')
            ->join('komponen_gajis', 'data_karyawans.id', '=', 'komponen_gajis.data_karyawan_id')
            ->where('periode', $previousMonth)
            ->select('komponen_gajis.*', 'data_karyawans.nama', 'data_karyawans.nik')
            ->where('data_karyawans.nik', $id)
            ->first();

        $total_deduction = $data->jht + $data->jp + $data->pot_bpjskes + $data->unpaid_leave + $data->deduction_pph21;
        $total_diterima = ($data->gaji_pokok + $data->tunj_um + $data->tunj_pengawas + $data->tunj_transport + $data->tunj_mk + $data->tunj_koefisien + $data->rapel + $data->insentif + $data->tunj_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        $pdf =  PDF::loadView('payslip.payslip-print', compact('data', 'total_diterima', 'total_deduction', 'gaji_bersih'));
        return $pdf->stream();
    }

    public function gajiKaryawan(Request $request)
    {
        $karyawan = employee::select('nik', 'nama_karyawan')->get();
        $departement = Departemen::all();

        return view('payslip.gaji-karyawan', compact('karyawan', 'departement'));
    }

    public function serverSideSalary(Request $request)
    {
        $now = new DateTime();
        $now->modify('-1 month');
        $previousMonth = $now->format('Y-m');

        $data = DB::connection('epayslip')
            ->table('data_karyawans')
            ->join('komponen_gajis', 'data_karyawans.id', '=', 'komponen_gajis.data_karyawan_id')
            ->where('periode', $previousMonth)
            ->select('komponen_gajis.*', 'data_karyawans.nama', 'data_karyawans.nik');

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('payslip._action', [
                    'data' => $data,
                    'url_show' => route('salary.show', $data->nik),
                ]);
            })
            ->filter(function ($instance) use ($request) {
                if($request->get('departemen') != '') {
                    $instance->where('departemen', $request->get('departemen'));
                }
                if($request->get('divisi') != ''){
                    $instance->where('divisi', $request->get('divisi'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->where('nama', 'LIKE', "%$search%");
                        $w->Orwhere('nik', 'LIKE', "%$search%");
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
        $now = new DateTime();
        $now->modify('-1 month');
        $previousMonth = $now->format('Y-m');

        $data = DB::connection('epayslip')
            ->table('data_karyawans')
            ->join('komponen_gajis', 'data_karyawans.id', '=', 'komponen_gajis.data_karyawan_id')
            ->where('periode', $previousMonth)
            ->select('komponen_gajis.*', 'data_karyawans.nama', 'data_karyawans.nik')
            ->where('data_karyawans.nik', $id)
            ->first();

        $total_deduction = $data->jht + $data->jp + $data->pot_bpjskes + $data->unpaid_leave + $data->deduction_pph21 + $data->deduction;
        $total_diterima = ($data->gaji_pokok + $data->tunj_um + $data->ot  + $data->tunj_pengawas + $data->tunj_transport + $data->tunj_mk + $data->tunj_koefisien + $data->rapel + $data->insentif + $data->tunj_lap);
        $gaji_bersih = ($total_diterima - $total_deduction);

        return view('payslip.show', compact('data', 'total_diterima', 'total_deduction', 'gaji_bersih'));
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
}

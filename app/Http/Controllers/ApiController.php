<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ApiController extends Controller
{
   public function searchEmployee(Request $request)
   {
      $search = $request->q;
      $data = employee::select('nik', 'nama_karyawan')->where('nik', 'like', '%' . $search . '%')->limit(10)->get();
      return response()->json($data);
   }

   public function searchEmployeeByDiv(Request $request)
   {
      $search = $request->q;
      $data = employee::select('nik', 'nama_karyawan')->where('status_resign', '!=',  null)->where('nik', 'like', '%' . $search . '%')->where('divisi_id', Auth::user()->employee->divisi_id)->limit(10)->get();
      return response()->json($data);
   }

   public function getEmployeeById($id)
   {
      $data_hris = employee::leftjoin('salaries', 'salaries.employee_id', '=', 'employees.nik')
         ->leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
         ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
         ->leftjoin('master_provinsi', 'master_provinsi.id', '=', 'employees.provinsi_id')
         ->leftjoin('master_kabupaten', 'master_kabupaten.id', '=', 'employees.kabupaten_id')
         ->leftjoin('master_kecamatan', 'master_kecamatan.id', '=', 'employees.kecamatan_id')
         ->leftjoin('master_kelurahan', 'master_kelurahan.id', '=', 'employees.kelurahan_id')
         ->leftjoin('sp_report', 'sp_report.nik_karyawan', '=', 'employees.nik')
         ->select(DB::raw("*, TIMESTAMPDIFF(YEAR, entry_date, CURDATE()) as service_year, TIMESTAMPDIFF(MONTH, entry_date, CURDATE()) as service_month"))
         ->orderBy('salaries.akhir_periode', 'desc')
         ->where('employees.nik', $id)->first();

      if ($data_hris) {
         // Apply the additional logic for service_month
         if ($data_hris->service_month <= '35') {
            $data_hris->service_month_award = 0;
         }
         if ($data_hris->service_month >= '36' && $data_hris->service_month <= '72') {
            $data_hris->service_month_award = 2;
         }
         if ($data_hris->service_month >= '73' && $data_hris->service_month <= '108') {
            $data_hris->service_month_award = 3;
         }
         if ($data_hris->service_month >= '109' && $data_hris->service_month <= '144') {
            $data_hris->service_month_award = 4;
         }
      }

      $check_exist = DB::connection('epayslip')->table('data_karyawans')->select('id', 'nik', 'nama')
         ->where('nik', $id)->first();

      $data_slip = DB::connection('epayslip')->table('komponen_gajis')->select('*')
         ->where('data_karyawan_id', $check_exist->id)
         ->orderBy('id', 'DESC')
         ->first();

      $collection = collect($data_hris);
      $merged = $collection->merge($data_slip);
      $data = $merged->all();

      return response()->json($data);
   }

   public function getAirport(Request $request)
   {
      if ($request->has('q')) {
         $search = $request->q;
         $data = Airports::select('*')->where('name', 'like', '%' . $search . '%')->orWhere('municipality', 'like', '%' . $search . '%')->limit(20)->get();;
         return response()->json($data);
      }
   }

   public function getDivisi($id)
   {
      $divisi = Divisi::where('departemen_id', $id)->get();
      return response()->json($divisi);
   }

   public function getEmployeeWithEntryDate(Request $request)
   {
      $data = employee::leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
         ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
         ->where('kode_area_kerja', '!=', null)
         ->select(DB::raw("*, tgl_lahir, TIMESTAMPDIFF(YEAR, tgl_lahir, NOW()) AS umur"));

      return DataTables::of($data)
         ->addIndexColumn()
         ->addColumn('action', function ($data) {
            return view('admin.employee._action', [
               'data' => $data,
               'url_show' => route('employees.edit', $data->nik),
            ]);
         })->filter(function ($instance) use ($request) {
            if ($request->get('status_karyawan') == 'PKWTT 固定工' || $request->get('status_karyawan') == 'PKWT 合同工' || $request->get('status_karyawan') == 'TRAINING') {
               $instance->where('status_karyawan', $request->get('status_karyawan'));
            }

            if ($request->get('area_kerja') != '') {
               $instance->where('area_kerja', $request->get('area_kerja'));
            }

            if ($request->get('departemen') != '') {
               $instance->where('departemen_id', $request->get('departemen'));
            }

            if ($request->get('jabatan') != '') {
               $instance->where('jabatan', $request->get('jabatan'));
            }

            if ($request->get('nama_divisi') != '') {
               $instance->where('divisi_id', $request->get('nama_divisi'));
            }

            if ($request->get('status_resign') != '') {

               $instance->where('status_resign', strtoupper($request->get('status_resign')));
            }
            if ($request->get('jenis_kelamin') != '') {
               $instance->where('jenis_kelamin', $request->get('jenis_kelamin'));
            }

            if ($request->get('pendidikan_terakhir') != '') {
               $instance->where('pendidikan_terakhir', $request->get('pendidikan_terakhir'));
            }

            if (($request->get('awal_umur') != '') && ($request->get('akhir_umur') != '')) {
               $instance->whereBetween('tgl_lahir', [date('Y-m-d', strtotime(Carbon::today()->subYears($request->get('akhir_umur')))), date('Y-m-d', strtotime(Carbon::today()->subYears($request->get('awal_umur'))))]);
            }

            if (($request->get('awal_umur') != '') && ($request->get('akhir_umur') == '')) {
               $instance->whereYear('tgl_lahir', date('Y-m-d', strtotime(Carbon::today()->subYears($request->get('awal_umur')))));
            }

            if ($request->get('provinsi_id') != '') {
               $instance->where('provinsi_id', $request->get('provinsi_id'));
            }

            if ($request->get('kabupaten_id') != '') {
               $instance->where('kabupaten_id', $request->get('kabupaten_id'));
            }

            if ($request->get('kecamatan_id') != '') {
               $instance->where('kecamatan_id', $request->get('kecamatan_id'));
            }

            if ($request->get('kelurahan_id') != '') {
               $instance->where('kelurahan_id', $request->get('kelurahan_id'));
            }

            if ($request->get('entry_date') != '') {
               $instance->where('entry_date', $request->get('entry_date'));
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
               $instance->whereBetween('entry_date', [$request->from_date, $request->to_date]);
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

   public function getEmployeeMonthly(Request $request)
   {
      $data = employee::leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
         ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
         ->where('kode_area_kerja', '!=', null)
         ->select(DB::raw("*, tgl_lahir, TIMESTAMPDIFF(YEAR, tgl_lahir, NOW()) AS umur"));

      return DataTables::of($data)
         ->addIndexColumn()
         ->addColumn('action', function ($data) {
            return view('admin.employee._action', [
               'data' => $data,
               'url_show' => route('employees.edit', $data->nik),
            ]);
         })->filter(function ($instance) use ($request) {
            if ($request->get('status_karyawan') == 'PKWTT 固定工' || $request->get('status_karyawan') == 'PKWT 合同工' || $request->get('status_karyawan') == 'TRAINING') {
               $instance->where('status_karyawan', $request->get('status_karyawan'));
            }

            if ($request->get('area_kerja') != '') {
               $instance->where('area_kerja', $request->get('area_kerja'));
            }

            if ($request->get('departemen') != '') {
               $instance->where('departemen_id', $request->get('departemen'));
            }

            if ($request->get('jabatan') != '') {
               $instance->where('jabatan', $request->get('jabatan'));
            }

            if ($request->get('nama_divisi') != '') {
               $instance->where('divisi_id', $request->get('nama_divisi'));
            }

            if ($request->get('status_resign') != '') {

               $instance->where('status_resign', strtoupper($request->get('status_resign')));
            }
            if ($request->get('jenis_kelamin') != '') {
               $instance->where('jenis_kelamin', $request->get('jenis_kelamin'));
            }

            if ($request->get('pendidikan_terakhir') != '') {
               $instance->where('pendidikan_terakhir', $request->get('pendidikan_terakhir'));
            }

            if (($request->get('awal_umur') != '') && ($request->get('akhir_umur') != '')) {
               $instance->whereBetween('tgl_lahir', [date('Y-m-d', strtotime(Carbon::today()->subYears($request->get('akhir_umur')))), date('Y-m-d', strtotime(Carbon::today()->subYears($request->get('awal_umur'))))]);
            }

            if (($request->get('awal_umur') != '') && ($request->get('akhir_umur') == '')) {
               $instance->whereYear('tgl_lahir', date('Y-m-d', strtotime(Carbon::today()->subYears($request->get('awal_umur')))));
            }

            if ($request->get('provinsi_id') != '') {
               $instance->where('provinsi_id', $request->get('provinsi_id'));
            }

            if ($request->get('kabupaten_id') != '') {
               $instance->where('kabupaten_id', $request->get('kabupaten_id'));
            }

            if ($request->get('kecamatan_id') != '') {
               $instance->where('kecamatan_id', $request->get('kecamatan_id'));
            }

            if ($request->get('kelurahan_id') != '') {
               $instance->where('kelurahan_id', $request->get('kelurahan_id'));
            }

            if ($request->get('periode') != '') {

               $periode = $request->periode;
               $periode = $periode . '-16';

               $minus_one_month = date('Y-m-d', strtotime("$periode -1 Month"));
               $plus_one_month_minus_one_day = date('Y-m-d', strtotime("$minus_one_month +1 Month -1 Day"));

               $instance->whereBetween('entry_date', [$minus_one_month, $plus_one_month_minus_one_day]);
            }

            if ($request->get('periode_resign') != '') {

               $periode = $request->periode_resign;
               $periode = $periode . '-16';

               $minus_one_month = date('Y-m-d', strtotime("$periode -1 Month"));
               $plus_one_month_minus_one_day = date('Y-m-d', strtotime("$minus_one_month +1 Month -1 Day"));

               $instance->whereBetween('tgl_resign', [$minus_one_month, $plus_one_month_minus_one_day]);
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

   public function getKabupaten(Request $request)
   {
      $data = Kabupaten::whereIn('id_provinsi', $request['selectedValuesProv'])->get();
      $output = '';

      foreach ($data as $row) {
         $output .= '<option value="' . $row["id"] . '">' . $row["kabupaten"] . '</option>';
      };

      echo $output;
   }

   public function getKecamatan(Request $request)
   {
      $data = Kecamatan::whereIn('id_kabupaten', $request['selectedValuesKab'])->get();
      $output = '';

      foreach ($data as $row) {
         $output .= '<option value="' . $row["id"] . '">' . $row["kecamatan"] . '</option>';
      };

      echo $output;
   }
}

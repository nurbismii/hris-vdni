<?php

namespace App\Http\Controllers;

use App\Models\Airports;
use App\Models\CutiRoster;
use App\Models\Divisi;
use App\Models\Pasal;
use App\Models\employee;
use App\Models\Kabupaten;
use App\Models\salary;
use App\Models\Severancepay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ApiController extends Controller
{
   public function searchEmployee(Request $request)
   {
      if ($request->has('q')) {
         $search = $request->q;
         $data = employee::select('nik', 'nama_karyawan')->where('nik', 'like', '%' . $search . '%')->limit(100)->get();
         return response()->json($data);
      }
   }

   public function getEmployeeById($id)
   {
      $data = employee::leftjoin('salaries', 'salaries.employee_id', '=', 'employees.nik')
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
}

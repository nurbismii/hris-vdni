<?php

namespace App\Http\Controllers;

use App\Models\Pasal;
use App\Models\employee;
use App\Models\Severancepay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
			->select(DB::raw("*, TIMESTAMPDIFF(YEAR, entry_date, CURDATE()) as service_year, TIMESTAMPDIFF(MONTH, entry_date, CURDATE()) as service_month"))
			->orderBy('salaries.akhir_periode', 'desc')
			->where('employees.nik', $id)->first();

		return response()->json($data);
	}
}

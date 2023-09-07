<?php

namespace App\Http\Controllers;

use App\Exports\EmployeeExport;
use App\Http\Requests\StoreEmployeeRequest;
use App\Imports\EmployeesDeleteImport;
use App\Imports\EmployeesImport;
use App\Imports\EmployeesUpdateImport;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $depts = Departemen::all();
        return view('employee.index', compact('depts'));
    }

    public function fetchDivisi($id)
    {
        $divisi = Divisi::where('departemen_id', $id)->get();
        return response()->json($divisi);
    }

    public function serverSideEmployee(Request $request)
    {
        $data = employee::leftjoin('divisis', 'divisis.id', '=', 'employees.divisi_id')
            ->leftjoin('departemens', 'departemens.id', '=', 'divisis.departemen_id')
            ->select(DB::raw("*, tgl_lahir, (year(curdate())-year(tgl_lahir)) as umur"));
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('employee._action', [
                    'data' => $data,
                    'url_show' => route('employee.edit', $data->nik),
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->get('status_karyawan') == 'PKWTT' || $request->get('status_karyawan') == 'PKWT' || $request->get('status_karyawan') == 'TRAINING') {
                    $instance->where('status_karyawan', $request->get('status_karyawan'));
                }
                if ($request->get('departemen') != '') {
                    $instance->where('departemen_id', $request->get('departemen'));
                }
                if ($request->get('nama_divisi') != '') {
                    $instance->where('divisi_id', $request->get('nama_divisi'));
                }
                if ($request->get('status_resign') != '') {
                    $instance->where('status_resign', $request->get('status_resign'));
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

    public function create()
    {
        return view('employee.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        employee::create($request->all());
        return back()->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit($nik)
    {
        try {
            $data = employee::where('nik', $nik)->first();
            $level_vaksin = $data->vaksin == '0' ? 'Belum Vaksin'
                : ($data->vaksin == '1' ? 'Vaksin 1'
                    : ($data->vaksin == '2' ? 'Vaksin 2'
                        : ($data->vaksin == '3' ? 'Booster 1'
                            : ($data->vaksin == '4' ? 'Booster 2'
                                : 'Tidak diketahui'))));
            return view('employee.edit', compact('data', 'level_vaksin'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            employee::where('nik', $id)->update([
                'no_sk_pkwtt' => $request['no_sk_pkwtt'],
                'nama_karyawan' => $request['nama_karyawan'],
                'nama_ibu_kandung' => $request['nama_ibu_kandung'],
                'nama_bapak' => $request['nama_bapak'],
                'agama' => $request['agama'],
                'kode_area_kerja' => $request['kode_area_kerja'],
                'no_ktp' => $request['no_ktp'],
                'no_kk' => $request['no_kk'],
                'jenis_kelamin' => $request['jenis_kelamin'],
                'status_perkawinan' => $request['status_perkawinan'],
                'status_karyawan' => $request['status_karyawan'],
                'tgl_resign' => $request->tgl_resign ?? null,
                'no_telp' => $request['no_telp'],
                'tgl_lahir' => $request->tgl_lahir ?? null,
                // 'provinsi_id' => $request['provinsi_id'],
                // 'kabupaten_id' => $request['kabupaten_id'],
                // 'kecamatan_id' => $request['kecamatan_id'],
                // 'kelurahan_id' => $request['kelurahan_id'],
                'alamat_ktp' => $request['alamat_ktp'],
                // 'alamat_domisili' => $request['alamat_domisili'],
                // 'rt' => $request['rt'],
                // 'rw' => $request['rw'],
                // 'kode_pos' => $request['kode_pos'],
                'area_kerja' => $request['area_kerja'],
                'golongan_darah' => $request['golongan_darah'],
                'entry_date' => $request->entry_date ?? null,
                'npwp' => $request['npwp'],
                'bpjs_kesehatan' => $request['bpjs_kesehatan'],
                'bpjs_tk' => $request['bpjs_tk'],
                'vaksin' => $request['vaksin'],
                'jam_kerja' => $request['jam_kerja'],
                'status_resign' => $request['status_resign'],
                'posisi' => $request['posisi'],
                'jabatan' => $request['jabatan'],
                // 'divisi_id' => $request['divisi_id'],
                // 'tinggi' => $request['tinggi'],
                // 'berat' => $request['berat'],
                // 'hobi' => $request['hobi'],
                // 'no_jamsostek' => $request['no_jamsostek'],
                // 'no_asuransi' => $request['no_asuransi'],
                // 'no_kartu_asuransi' => $request['no_kartu_asuransi'],
                // 'nama_bank' => $request['nama_bank'],
                // 'no_rekening' => $request['no_rekening'],
                // 'nama_instansi_pendidikan' => $request['nama_instansi_pendidikan'],
                // 'pendidikan_terakhir' => $request['pendidikan_terakhir'],
                // 'jurusan' => $request['jurusan'],
                // 'tanggal_kelulusan' => $request['tanggal_kelulusan'],
                // 'tanggal_menikah' => $request['tanggal_menikah']
            ]);
            return redirect('employees')->with('success', 'Data karyawan berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect('employees')->with('error', 'Terjadi kesalahan!');
        }
    }

    public function destroy($id)
    {
        try {
            employee::where('nik', $id)->delete();
            return back()->with('success', 'Karyawan berhasil dihapus');
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function import()
    {
        return view('employee.import');
    }

    public function downloadExample()
    {
        return Excel::download(new EmployeeExport, 'Template Karyawan.xlsx');
    }

    public function importEmployee(Request $request)
    {
        Excel::import(new EmployeesImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil ditambahkan');
    }

    public function updateImportEmployee(Request $request)
    {
        Excel::import(new EmployeesUpdateImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil diperbarui');
    }

    public function destroyImportEmployee(Request $request)
    {
        Excel::import(new EmployeesDeleteImport, $request->file('file'));
        return back()->with('success', 'Data Karyawan Berhasil dihapus');
    }
}

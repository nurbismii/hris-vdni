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
use App\Models\Mutasi;
use App\Models\PosisiLama;
use App\Models\Provinsi;
use App\Models\Resign;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    public function index()
    {
        $depts = Departemen::all();

        $provinsi = Provinsi::all();

        return view('employee.index', compact('depts', 'provinsi'));
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
            ->where('kode_area_kerja', '!=', null)
            ->select(DB::raw('*, tgl_lahir, TIMESTAMPDIFF(YEAR, tgl_lahir, NOW()) AS umur'));

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('employee._action', [
                    'data' => $data,
                    'url_show' => route('employee.edit', $data->nik),
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
            $data = employee::with('cutiIzin', 'spreportMany')->where('nik', $nik)->first();

            $data_resign = Resign::where('nik_karyawan', $data->nik)->first();

            $mutasi = Mutasi::with('posisi_lama')->where('nik_karyawan', $data->nik)->get();

            $level_vaksin = $data->vaksin == '0' ? 'Belum Vaksin'
                : ($data->vaksin == '1' ? 'Vaksin 1'
                    : ($data->vaksin == '2' ? 'Vaksin 2'
                        : ($data->vaksin == '3' ? 'Booster 1'
                            : ($data->vaksin == '4' ? 'Booster 2'
                                : 'Tidak diketahui'))));

            return view('employee.edit', compact('data', 'mutasi', 'level_vaksin', 'data_resign'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Terjadi kesalahan');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            employee::where('nik', $id)->update([
                'no_kk' => $request->no_kk,
                'nama_karyawan' => $request->nama_karyawan,
                'nama_ibu_kandung' => $request->nama_ibu_kandung,
                'no_ktp' => $request->no_ktp,
                'posisi' => $request->posisi,
                'jabatan' => $request->jabatan,
                'alamat_ktp' => $request->alamat_ktp,
                'jenis_kelamin' => $request->jenis_kelamin,
                'status_perkawinan' => $request->status_perkawinan,
                'no_telp' => $request->no_telp,
                'npwp' => $request->npwp,
                'bpjs_kesehatan' => $request->bpjs_kesehatan,
                'bpjs_tk' => $request->bpjs_tk,
                'vaksin' => $request->vaksin,
                'jam_kerja' => $request->jam_kerja,
                'area_kerja' =>  $request->area_kerja,
                'golongan_darah' => $request->golongan_darah,
                'tgl_lahir' => $request->tgl_lahir,
                'entry_date' => $request->entry_date,
                'sisa_cuti' => $request->sisa_cuti,
                'sisa_cuti_covid' => $request->sisa_cuti_covid,
            ]);
            return back()->with('success', 'Data karyawan berhasil diperbarui');
        } catch (\Throwable $e) {
            return redirect('employees')->with('error', 'Terjadi kesalahan!');
        }
    }

    public function updateKontrak(Request $request, $id)
    {
        try {
            employee::where('nik', $id)->update([
                'no_sk_pkwtt' => $request['no_sk_pkwtt'],
                'status_karyawan' => $request['status_karyawan'],
                'status_resign' => $request['status_resign'],
                'kategori_keluar' => $request['kategori_keluar'],
            ]);
            return back()->with('success', 'Data kontrak berhasil diperbarui');
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

    public function mutasi()
    {
        $depts = Departemen::all();
        return view('employee.mutasi', compact('depts'));
    }

    public function mutasiUpdate(Request $request)
    {
        $data = employee::where('nik', $request->nik)->first();

        $div = Divisi::where('id', $data->divisi_id)->first();

        $cek_file = Mutasi::where('nik_karyawan', $request->nik)->first();

        if ($request->hasFile('file')) {
            $upload = $request->file('file');
            $file_name = $request->nik . ' - ' . $upload->getClientOriginalName();
            $path = public_path('/mutasi/' . $request->nik . '/' . $request->tanggal_mutasi . '/');
            if (file_exists(isset($cek_file->file))) {
                unlink($path . $cek_file->file);
            }
            $upload->move($path, $file_name);

            DB::beginTransaction();

            $mutasi = Mutasi::create([
                'nik_karyawan' => $request->nik,
                'departemen_id' => $request->departemen_id,
                'divisi_id' => $request->divisi_id,
                'jabatan' => $request->posisi,
                'tanggal_mutasi' => date('Y-m-d', strtotime($request->tanggal_mutasi)),
                'area_kerja' => $request->area_kerja,
                'alasan_mutasi' => $request->alasan_mutasi,
                'berkas_pendukung' => $file_name
            ]);

            PosisiLama::create([
                'departemen_lama_id' => $div->departemen_id,
                'mutasi_id' => $mutasi->id,
                'divisi_lama_id' => $data->divisi_id,
                'area_kerja_lama' => $data->area_kerja,
                'jabatan_lama' => $data->posisi,
            ]);

            if ($mutasi->area_kerja != 'VDNI') {
                $data->update([
                    'divisi_id' => $mutasi->divisi_id,
                    'posisi' => $mutasi->jabatan,
                    'area_kerja' => $mutasi->area_kerja,
                    'status_resign' => 'Mutasi'
                ]);
            } else {
                $data->update([
                    'divisi_id' => $mutasi->divisi_id,
                    'posisi' => $mutasi->jabatan,
                    'area_kerja' => $mutasi->area_kerja,
                ]);
            }
            DB::commit();
            return back()->with('success', 'Berhasil melakukan mutasi');
        }
    }

    public function weekly(Request $request)
    {
        $depts = Departemen::all();
        $provinsi = Provinsi::all();

        return view('employee.weekly.index', compact('depts', 'provinsi'));
    }

    public function monthly(Request $request)
    {
        $depts = Departemen::all();
        $provinsi = Provinsi::all();

        return view('employee.monthly.index', compact('depts', 'provinsi'));
    }
}

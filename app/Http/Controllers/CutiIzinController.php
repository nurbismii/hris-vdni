<?php

namespace App\Http\Controllers;

use App\Models\CutiIzin;
use App\Models\employee;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class CutiIzinController extends Controller
{
    public function index()
    {
        return view('comben.pengajuan.index');
    }

    public function serverSidePengajuan(Request $request)
    {
        $data = CutiIzin::leftjoin('employees', 'employees.nik', '=', 'cuti_izin.nik_karyawan');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('comben.pengajuan._action', [
                    'data' => $data,
                    'url_update_diterima' => route('pengajuan-karyawan-setuju/update', $data->id),
                    'url_update_ditolak' => route('pengajuan-karyawan-ditolak/update', $data->id),
                    'url_foto' => 'dokumentasi/' . $data->nik_karyawan . '/' . $data->foto,
                    'url_delete' => route('pengajuan-karyawan/destroy', $data->id)
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->status_hrd == 'Diterima' || $request->status_hrd == 'Ditolak' || $request->status_hrd == 'Menunggu') {
                    $instance->where('status_hrd', $request->get('status_hrd'));
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('nik_karyawan', 'LIKE', "%$search%")
                            ->orWhere('nama_karyawan', 'LIKE', "%$search%");
                    });
                }
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function cutiIzin()
    {
        $data = employee::where('nik', Auth::user()->employee->nik)->first();
        $tanggal_sekarang = date('Y-m-d', strtotime(Carbon::now()));
        return view('cuti-izin.cuti', compact('data', 'tanggal_sekarang'))->with('no');
    }

    public function storeCutiIzin(Request $request)
    {
        $awal = new DateTime($request->tgl_mulai_cuti);
        $akhir = new DateTime($request->tgl_akhir_cuti);

        $sisa_cuti = 5;

        if ($akhir->diff($awal)->days > $sisa_cuti) {
            return back()->with('info', 'Hak cuti kamu tidak mencukupi...');
        }

        // if ($request->hasFile('foto_pendukung')) {
        //     $upload = $request->file('foto_pendukung');
        //     $file_name = $request->nik . '-' . $upload->getClientOriginalName();
        //     $path = public_path('/dokumentasi/' . $request->nik . '/');
        //     $upload->move($path, $file_name);
        // }

        CutiIzin::create([
            'nik_karyawan' => $request->nik,
            'tanggal' => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : '',
            'tanggal_mulai' => $request->tgl_mulai_cuti,
            'tanggal_berakhir' => $request->tgl_akhir_cuti,
            'status_pemohon' => 'ya',
            'status_hrd' => 'Menunggu',
            'status_hod' => 'Menunggu',
            'status_penanggung_jawab' => 'Menunggu',
            'tipe' => 'cuti',
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan, untuk melihat status pengajuan silahkan ke profil >>> Akun >>> Pengajuan');
    }

    public function updatePengajuanKaryawanDiterima($id)
    {
        $data = [
            'status_hrd' => 'Diterima'
        ];

        CutiIzin::where('id', $id)->update($data);

        return back()->with('success', 'Pengajuan berhasil diperbarui');
    }

    public function updatePengajuanKaryawanDitolak($id)
    {
        $data = [
            'status_hrd' => 'Ditolak'
        ];

        CutiIzin::where('id', $id)->update($data);

        return back()->with('success', 'Pengajuan berhasil diperbarui');
    }

    public function pengajuanKaryawanDestory($id)
    {
        $data = CutiIzin::where('id', $id)->first();
        unlink(public_path('dokumentasi/' . $data->nik_karyawan . '/' . $data->foto));
        $data->delete();
        return back()->with('success', 'Pengajuan berhasil dihapus');
    }
}

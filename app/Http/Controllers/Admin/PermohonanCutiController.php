<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CutiIzin;
use App\Models\CutiRoster;
use App\Models\employee;
use App\Models\Kabupaten;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PermohonanCutiController extends Controller
{
    public function index()
    {
        return view('admin.comben.pengajuan.index');
    }

    public function serverSidePengajuan(Request $request)
    {
        try {
            $data = CutiIzin::leftjoin('employees', 'employees.nik', '=', 'cuti_izin.nik_karyawan')
                ->orderBy('cuti_izin.tanggal', 'desc')
                ->select('cuti_izin.*', 'employees.nama_karyawan');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('admin.comben.pengajuan._action', [
                        'data' => $data,
                        'url_foto' => 'izin-dibayarkan/' . $data->nik_karyawan . '/' . $data->foto,
                        'url_delete' => route('pengajuan-karyawan/destroy', $data->id),
                        'url_diterima' => route('update.statuspengajuan.diterima', $data->id),
                        'url_ditolak' => route('update.statuspengajuan.ditolak', $data->id)
                    ]);
                })->filter(function ($instance) use ($request) {
                    if ($request->tipe == 'cuti' || $request->tipe == 'izin dibayarkan' || $request->tipe == 'izin tidak dibayarkan') {
                        $instance->where('tipe', $request->get('tipe'));
                    }
                    if ($request->status_hrd == 'Menunggu' || $request->status_hrd == 'Diterima' || $request->status_hrd == 'Ditolak') {
                        $instance->where('status_hrd', $request->get('status_hrd'));
                    }
                    if ($request->status_hod == 'Menunggu' || $request->status_hod == 'Diterima') {
                        $instance->where('status_hod', $request->get('status_hod'));
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
        } catch (\Throwable $e) {
            return back()->with('success', 'Berkas yang dilampirkan tidak tersedia');
        }
    }

    public function pengajuanKaryawanDestroy($id)
    {
        $data = CutiIzin::where('id', $id)->first();
        if (!$data->foto) {
            $data->delete();
            return back()->with('success', 'Pengajuan berhasil dihapus');
        }
        unlink(public_path('izin-dibayarkan/' . $data->nik_karyawan . '/' . $data->foto));
        $data->delete();
        return back()->with('success', 'Pengajuan berhasil dihapus');
    }

    public function cutiRoster()
    {
        $data = CutiRoster::select('*')->orderBy('id', 'DESC')->get();
        return view('admin.comben.cuti-roster.index', compact('data'));
    }

    public function serverSideCutiRoster(Request $request)
    {
        $data = CutiRoster::join('employees', 'employees.nik', '=', 'cuti_roster.nik_karyawan')
            ->join('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->orderBy('cuti_roster.id', 'desc')
            ->select('cuti_roster.*', 'employees.nama_karyawan',  'periode_kerja_roster.tipe_rencana');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('comben.cuti-roster._action', [
                    'data' => $data,
                    'url_detail' => route('cutiroster.show', $data->id)
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->status_pengajuan == 'menunggu' || $request->status_pengajuan == 'diterima' || $request->status_pengajuan == 'ditolak') {
                    $instance->where('status_pengajuan', $request->get('status_pengajuan'));
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

    public function updateStatusPengajuanDiterima($id)
    {
        $CT = 1;

        $data = CutiIzin::find($id);

        if ($data->status_hrd == 'Diterima') {
            return back()->with('info', 'Pengajuan ini telah diterima');
        }

        $data_employee = employee::where('nik', $data->nik_karyawan)->first();

        // Update status cuti
        $data->update(['status_hrd' => 'Diterima']);

        // Update sisa cuti berdasarkan kategori
        if ($data->kategori_cuti == $CT) {
            $data_employee->decrement('sisa_cuti', $data->jumlah);
        } else {
            $data_employee->decrement('sisa_cuti_covid', $data->jumlah);
        }

        return back()->with('success', 'Pengajuan telah diterima');
    }

    public function updateStatusPengajuanDitolak($id)
    {
        $data = CutiIzin::where('id', $id)->first();

        if ($data->status_hrd == 'Diterima') {
            employee::where('nik', $data->nik_karyawan)->increment('sisa_cuti', $data->jumlah);
            $data->update([
                'status_hrd' => 'Ditolak',
            ]);
        }

        $data->update([
            'status_hrd' => 'Ditolak',
        ]);

        return back()->with('success', 'Pengajuan telah ditolak');
    }

    public function cutiRosterCreate()
    {
        $kota = Kabupaten::all();
        return view('comben.cuti-roster.create', compact('kota'));
    }

    public function cutiRosterStore(Request $request)
    {
        $cek_file = CutiRoster::where('id', $request->nik_karyawan)->first();
        if ($request->hasFile('berkas_cuti')) {
            $upload = $request->file('berkas_cuti');
            $file_name = $request->nik_karyawan . ' - ' . $upload->getClientOriginalName();
            $path = public_path('/cuti-roster/' . $request->nik_karyawan . '/' . $request->tgl_pengajuan . '/');
            if ($cek_file->file) {
                unlink($path . $cek_file->file);
            }
            $upload->move($path, $file_name);
        }

        $data = [
            'nik_karyawan' => $request->nik_karyawan,
            'email' => $request->email,
            'tanggal_pengajuan' => date('Y-m-d', strtotime($request->tanggal_pengajuan)),
            'tgl_mulai_cuti' => date('Y-m-d', strtotime($request->tgl_mulai_cuti)),
            'tgl_mulai_cuti_tahunan' => date('Y-m-d', strtotime($request->tgl_mulai_cuti_tahunan)),
            'tgl_mulai_off' => date('Y-m-d', strtotime($request->tgl_mulai_off)),
            'tgl_keberangkatan' => date('Y-m-d', strtotime($request->tgl_keberangkatan)),
            'jam_keberangkatan' => $request->jam_keberangkatan,
            'kota_awal_keberangkatan' => $request->kota_awal_keberangkatan,
            'kota_tujuan_keberangkatan' => $request->kota_tujuan_keberangkatan,
            'catatan_penting_keberangkatan' => $request->catatan_penting_keberangkatan,
            'tgl_mulai_cuti_berakhir' => date('Y-m-d', strtotime($request->tgl_mulai_cuti_berakhir)),
            'tgl_mulai_cuti_tahunan_berakhir' => date('Y-m-d', strtotime($request->tgl_mulai_cuti_tahunan_berakhir)),
            'tgl_mulai_off_berakhir' => date('Y-m-d', strtotime($request->tgl_mulai_off_berakhir)),
            'tgl_kepulangan' => date('Y-m-d', strtotime($request->tgl_kepulangan)),
            'jam_kepulangan' => $request->jam_kepulangan,
            'kota_awal_kepulangan' => $request->kota_awal_kepulangan,
            'kota_tujuan_kepulangan' => $request->kota_tujuan_kepulangan,
            'catatan_penting_kepulangan' => $request->catatan_penting_kepulangan,
            'file' => $file_name,
            'status_pengajuan' => 'menunggu'
        ];

        CutiRoster::create($data);
        return back()->with('success', 'Berhasil melakukan pengajuan cuti roster');
    }

    public function cutiRosterUpdate(Request $request, $id)
    {
        CutiRoster::where('id', $id)->update([
            'status_pengajuan_hrd' => $request->status_pengajuan,
        ]);

        return back()->with('success', 'Berhasil melakukan perubahan status pengajuan');
    }

    public function cutiRosterShow($id)
    {
        $data = CutiRoster::with('karyawan', 'periode_kerja')->where('id', $id)->first();
        return view('comben.cuti-roster.show', compact('data'));
    }

    public function downloadTiketPesawat($id)
    {
        $data = CutiRoster::where('id', $id)->first();
        return response()->download(public_path('cuti-roster/' . $data->nik_karyawan . '/' . $data->tanggal_pengajuan . '/' . $data->tiket_pesawat));
    }

    public function downloadBerkas($id)
    {
        $data = CutiRoster::where('id', $id)->first();
        return response()->download(public_path('cuti-roster/' . $data->nik_karyawan . '/' . $data->file));
    }
}

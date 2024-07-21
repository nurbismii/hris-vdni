<?php

namespace App\Http\Controllers;

use App\Imports\PengajuanImport;
use App\Models\CutiIzin;
use App\Models\CutiRoster;
use App\Models\employee;
use App\Models\Kabupaten;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class CutiIzinController extends Controller
{
    public function index()
    {
        return view('comben.pengajuan.index');
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
                    return view('comben.pengajuan._action', [
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

    public function cutiIzin()
    {
        return view('comben.cuti-izin.cuti');
    }

    public function storeCutiIzin(Request $request)
    {
        try {
            $awal = new DateTime($request->tgl_mulai_cuti);
            $akhir = new DateTime($request->tgl_akhir_cuti);

            if ($akhir->diff($awal)->days > $request->sisa_cuti) {
                return back()->with('info', 'Hak cuti kamu tidak mencukupi...');
            }

            CutiIzin::create([
                'nik_karyawan' => $request->nik,
                'tanggal' => $request->tanggal_pengajuan,
                'keterangan' => $request->keterangan,
                'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days + '1',
                'tanggal_mulai' => $request->tgl_mulai_cuti,
                'tanggal_berakhir' => $request->tgl_akhir_cuti,
                'status_pemohon' => 'ya',
                'tipe' => 'cuti',
            ]);

            return back()->with('success', 'Berhasil melakukan pengajuan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan ' . $e->getMessage());
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

    public function izinDibayar()
    {
        return view('comben.cuti-izin.izin-dibayarkan');
    }

    public function storeIzinDibayarkan(Request $request)
    {
        $awal = new DateTime($request->tgl_mulai_cuti);
        $akhir = new DateTime($request->tgl_akhir_cuti);

        if ($request->hasFile('foto')) {
            $upload = $request->file('foto');
            $file_name = $request->nik . '-' . $upload->getClientOriginalName();
            $path = public_path('/izin-dibayarkan/' . $request->nik . '/');
            $upload->move($path, $file_name);
        }

        CutiIzin::create([
            'nik_karyawan' => $request->nik,
            'tanggal' => $request->tanggal_pengajuan,
            'keterangan' => $request->tipe_izin,
            'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days + 1,
            'tanggal_mulai' => $request->tgl_mulai_cuti,
            'tanggal_berakhir' => $request->tgl_akhir_cuti,
            'status_pemohon' => 'ya',
            'tipe' => 'izin dibayarkan',
            'foto' => $file_name
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan');
    }

    public function izinTidakDibayarkan()
    {
        $data = employee::where('nik', Auth::user()->employee->nik)->first();
        $tanggal_sekarang = date('Y-m-d', strtotime(Carbon::now()));
        return view('comben.cuti-izin.izin-tidak-dibayarkan', compact('data', 'tanggal_sekarang'));
    }

    public function storeIzinTidakDibayarkan(Request $request)
    {
        $awal = new DateTime($request->tgl_mulai_cuti);
        $akhir = new DateTime($request->tgl_akhir_cuti);

        CutiIzin::create([
            'nik_karyawan' => $request->nik,
            'tanggal' => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days,
            'tanggal_mulai' => $request->tgl_mulai_cuti,
            'tanggal_berakhir' => $request->tgl_akhir_cuti,
            'status_pemohon' => 'ya',
            'tipe' => 'izin tidak dibayarkan',
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan');
    }

    public function cutiRoster()
    {
        $data = CutiRoster::select('*')->orderBy('id', 'DESC')->get();
        return view('comben.cuti-roster.index', compact('data'));
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

    public function adminCutiRosterUpdate(Request $request, $id)
    {
        CutiRoster::where('id', $id)->update([
            'status_pengajuan' => $request->status_pengajuan,
        ]);

        return back()->with('success', 'Berhasil melakukan perubahan status pengajuan');
    }

    public function cutiRosterShow($id)
    {
        $data = CutiRoster::with('karyawan', 'periode_kerja')->where('id', $id)->first();
        return view('comben.cuti-roster.show', compact('data'));
    }

    public function uploadTiketPesawat(Request $request, $id)
    {
        $data = CutiRoster::where('id', $id)->first();

        if ($request->hasFile('tiket_pesawat')) {

            $upload = $request->file('tiket_pesawat');
            $file_name = $data->nik_karyawan . ' -' . ' TIKET PESAWAT - ' . $upload->getClientOriginalName();
            $path = public_path('/cuti-roster/' . $data->nik_karyawan . '/' . $data->tanggal_pengajuan . '/');
            if ($data->tiket_pesawat) {
                unlink($path . $data->tiket_pesawat);
            }

            $upload->move($path, $file_name);
            $data->update([
                'tiket_pesawat' => $file_name,
            ]);
        }
        return back()->with('success', 'Berhasil melakukan upload tiket pesawat');
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

    public function importViewPengajuan()
    {
        return view('comben.pengajuan.import');
    }

    public function importStorePengajuan(Request $request)
    {
        Excel::import(new PengajuanImport, $request->file('file'));
        return back()->with('success', 'Berhasil melakukan impor pengajuan');
    }

    public function viewAdminDeptCuti()
    {
        return view('admin-dept.cuti.index');
    }

    public function serversideAdminCuti(Request $request)
    {
        $data = CutiIzin::leftjoin('employees', 'employees.nik', '=', 'cuti_izin.nik_karyawan')
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->orderBy('cuti_izin.created_at', 'desc')
            ->select('cuti_izin.*', 'employees.nama_karyawan');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return view('admin-dept.cuti._action', [
                    'data' => $data,
                    'url_update' => route('adminupdate.statuspengajuan', $data->id)
                ]);
            })->filter(function ($instance) use ($request) {
                if ($request->tipe == 'cuti' || $request->tipe == 'izin dibayarkan' || $request->tipe == 'izin tidak dibayarkan') {
                    $instance->where('tipe', $request->get('tipe'));
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

    public function viewAdminDeptCutiTahunan()
    {
        return view('admin-dept.cuti.cuti');
    }

    public function adminDeptstoreCutiTahunan(Request $request)
    {
        try {
            $awal = new DateTime($request->tgl_mulai_cuti);
            $akhir = new DateTime($request->tgl_akhir_cuti);

            if ($akhir->diff($awal)->days > $request->sisa_cuti) {
                return back()->with('info', 'Hak cuti kamu tidak mencukupi...');
            }

            DB::beginTransaction();

            CutiIzin::create([
                'nik_karyawan' => $request->nik,
                'tanggal' => $request->tanggal_pengajuan,
                'keterangan' => $request->keterangan,
                'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days + '1',
                'tanggal_mulai' => $request->tgl_mulai_cuti,
                'tanggal_berakhir' => $request->tgl_akhir_cuti,
                'status_pemohon' => 'ya',
                'status_hrd' => 'Menunggu',
                'status_hod' => 'Menunggu',
                'status_penanggung_jawab' => 'Menunggu',
                'tipe' => 'cuti',
            ]);

            DB::commit();

            return back()->with('success', 'Berhasil melakukan pengajuan');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan pada sistem');
        }
    }

    public function viewAdminDeptPaidLeave()
    {
        return view('admin-dept.cuti.izin-dibayarkan');
    }

    public function viewAdminStorePaidLeave(Request $request)
    {
        $awal = new DateTime($request->tgl_mulai_cuti);
        $akhir = new DateTime($request->tgl_akhir_cuti);

        if ($request->hasFile('foto')) {
            $upload = $request->file('foto');
            $file_name = $request->nik . '-' . $upload->getClientOriginalName();
            $path = public_path('/izin-dibayarkan/' . $request->nik . '/');
            $upload->move($path, $file_name);
        }

        CutiIzin::create([
            'nik_karyawan' => $request->nik,
            'tanggal' => $request->tanggal_pengajuan,
            'keterangan' => $request->tipe_izin,
            'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days + 1,
            'tanggal_mulai' => $request->tgl_mulai_cuti,
            'tanggal_berakhir' => $request->tgl_akhir_cuti,
            'status_pemohon' => 'ya',
            'status_hrd' => 'Menunggu',
            'status_hod' => 'Menunggu',
            'status_penanggung_jawab' => 'Menunggu',
            'tipe' => 'izin dibayarkan',
            'foto' => $file_name
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan');
    }

    public function viewAdminDeptUnpaidLeave()
    {
        return view('admin-dept.cuti.izin-tidak-dibayarkan');
    }

    public function viewAdminStoreUnpaidLeave(Request $request)
    {
        $awal = new DateTime($request->tgl_mulai_cuti);
        $akhir = new DateTime($request->tgl_akhir_cuti);

        CutiIzin::create([
            'nik_karyawan' => $request->nik,
            'tanggal' => $request->tanggal_pengajuan,
            'keterangan' => $request->keterangan,
            'jumlah' => $akhir->diff($awal)->days == '0' ? '1' : $akhir->diff($awal)->days,
            'tanggal_mulai' => $request->tgl_mulai_cuti,
            'tanggal_berakhir' => $request->tgl_akhir_cuti,
            'status_pemohon' => 'ya',
            'status_hrd' => 'Menunggu',
            'status_hod' => 'Menunggu',
            'status_penanggung_jawab' => 'Menunggu',
            'tipe' => 'izin tidak dibayarkan',
        ]);

        return back()->with('success', 'Berhasil melakukan pengajuan');
    }

    public function adminUpdateStatusPengajuan($id)
    {
        CutiIzin::where('id', $id)->update([
            'status_hod' => 'Diterima'
        ]);
        return back()->with('success', 'Status pengajuan telah disetujui oleh Head of Departement');
    }

    public function viewAdminDeptDetailPengajuan($id)
    {
        $data = CutiRoster::join('employees', 'employees.nik', '=', 'cuti_roster.nik_karyawan')
            ->join('periode_kerja_roster', 'periode_kerja_roster.cuti_roster_id', '=', 'cuti_roster.id')
            ->orderBy('cuti_roster.id', 'desc')
            ->select('cuti_roster.*', 'employees.nama_karyawan',  'periode_kerja_roster.tipe_rencana')
            ->where('cuti_roster.id', $id)
            ->where('employees.divisi_id', Auth::user()->employee->divisi_id)
            ->first();

        return view('admin-dept.pengingat.permohonan-detail', compact('data'));
    }
}

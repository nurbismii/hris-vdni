<?php

namespace App\Repositories\Absensi;

use App\Models\Absensi;
use App\Models\employee;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AbsensiRepositoryImplement implements AbsensiRepository
{
  public function getAbsensiByNik()
  {
    try {
      $data = Absensi::orderBy('created_at', 'DESC')->where('nik_karyawan', Auth::user()->employee->nik)->get();
      return $data;
    } catch (Exception $e) {
      return back()->with('error', 'Terjadi kesalahan');
    }
  }

  public function getAbsensiHariIni()
  {
    try {
      $data = Absensi::where('nik_karyawan', Auth::user()->employee->nik)->whereDate('created_at', Carbon::today())->latest()->first();
      return $data;
    } catch (Exception $e) {
      return back()->with('error', 'Terjadi kesalahan');
    }
  }

  public function checkKaryawan($nik)
  {
    try {
      $data = employee::where('nik', $nik)->first();
      return $data;
    } catch (Exception $e) {
      return back()->with('error', 'Terjadi kesalahan');
    }
  }
}

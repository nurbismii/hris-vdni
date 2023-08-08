<?php

namespace App\Repositories\Absensi;

interface AbsensiRepository
{
  public function getAbsensiByNik();

  public function getAbsensiHariIni();

  public function checkKaryawan($nik);
}

<?php

use App\Repositories\Absensi\AbsensiRepository;
use App\Services\Absensi\AbsensiService;

class AbsensiServiceImplement implements AbsensiService
{
  public $mainRepoAbsensi;

  public function __construct(AbsensiRepository $mainRepoAbsensi)
  {
    $this->mainRepoAbsensi = $mainRepoAbsensi;
  }
}

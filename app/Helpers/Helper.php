<?php

use App\Models\employee;
use App\Models\Pengingat;
use Carbon\Carbon;

function getName($id)
{
    $data = employee::where('nik', $id)->first();
    if ($data === null) {
        $retval = "";
    } else {
        $retval = $data->nama_karyawan;
    }
    return $retval;
}

function prev_segments($uri)
{
    $segments = explode('/', str_replace('' . url('') . '', '', $uri));

    return array_values(array_filter($segments, function ($value) {
        return $value !== '';
    }));
}

function getCountPengingat()
{
    $count_pengingat = [];
    $count_pengingat = Pengingat::where('flg_kirim', '1')->get();
    return $count_pengingat->count();
}

function getNotifPengingat()
{
    $datas = [];
    $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->limit(4)->get();
    return $datas;
}

function getAllPengingat()
{
    $datas = [];
    $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->get();
    return $datas;
}

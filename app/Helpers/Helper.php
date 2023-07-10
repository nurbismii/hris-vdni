<?php

use App\Models\employee;
use App\Models\Kecamatan;
use App\Models\Pengingat;
use App\Models\PeriodeBulan;
use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

function getName($id)
{
    $data = employee::where('nik', $id)->first('nama_karyawan');
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
    $count_pengingat = Pengingat::where('flg_kirim', '1')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('nik_karyawan', Auth::user()->employee->nik)->get();
    return $count_pengingat->count();
}

function getNotifPengingat()
{
    $datas = [];
    $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->where('nik_karyawan', Auth::user()->employee->nik)->limit(4)->get();
    return $datas;
}

function getAllPengingat()
{
    $datas = [];
    $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>=', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->get();
    return $datas;
}


function getDataResign($karyawan_resign, $tahun_sekarang)
{
    $resign_record = [];
    $validation1 = [];
    $chart_resign = '';

    foreach ($karyawan_resign as $ks) {
        $validation1[] = date('Y', strtotime($ks->tgl_resign));
    }

    foreach ($karyawan_resign as $ks) {
        $resign_record[] = date('m', strtotime($ks->tgl_resign));
    }


    for ($i = 0; $i < count($resign_record); $i++) :
        if ($validation1[$i] == $tahun_sekarang) :
            $jan1[] = $resign_record[$i] == "01" ? $resign_record[$i] : [];
            $feb1[] = $resign_record[$i] == "02" ? $resign_record[$i] : [];
            $maret1[] = $resign_record[$i] == "03" ? $resign_record[$i] : [];
            $april1[] = $resign_record[$i] == "04" ? $resign_record[$i] : [];
            $mei1[] = $resign_record[$i] == "05" ? $resign_record[$i] : [];
            $juni1[] = $resign_record[$i] == "06" ? $resign_record[$i] : [];
            $juli1[] = $resign_record[$i] == "07" ? $resign_record[$i] : [];
            $agust1[] = $resign_record[$i] == "08" ? $resign_record[$i] : [];
            $sept1[] = $resign_record[$i] == "09" ? $resign_record[$i] : [];
            $okt1[] = $resign_record[$i] == "10" ? $resign_record[$i] : [];
            $nov1[] = $resign_record[$i] == "11" ? $resign_record[$i] : [];
            $dec1[] = $resign_record[$i] == "12" ? $resign_record[$i] : [];
        endif;
    endfor;

    if (count($resign_record) > 0) {
        $chart_resign = [
            count(array_filter($jan1)),
            count(array_filter($feb1)),
            count(array_filter($maret1)),
            count(array_filter($april1)),
            count(array_filter($mei1)),
            count(array_filter($juni1)),
            count(array_filter($juli1)),
            count(array_filter($agust1)),
            count(array_filter($sept1)),
            count(array_filter($okt1)),
            count(array_filter($nov1)),
            count(array_filter($dec1))
        ];
    }

    return $chart_resign;
}

function getDataRekrut($data_contract, $tahun_sekarang)
{
    $rekrutmen_record = [];
    $validation = [];
    $chart_rekrut = '';

    foreach ($data_contract as $d) {
        $validation[] = date('Y', strtotime($d->tanggal_mulai_kontrak));
    }

    foreach ($data_contract as $d) {
        $rekrutmen_record[] = date('m', strtotime($d->tanggal_mulai_kontrak));
    }

    for ($i = 0; $i < count($rekrutmen_record); $i++) :
        if ($validation[$i] == $tahun_sekarang) :
            $jan[] = $rekrutmen_record[$i] == "01" ? $rekrutmen_record[$i] : [];
            $feb[] = $rekrutmen_record[$i] == "02" ? $rekrutmen_record[$i] : [];
            $maret[] = $rekrutmen_record[$i] == "03" ? $rekrutmen_record[$i] : [];
            $april[] = $rekrutmen_record[$i] == "04" ? $rekrutmen_record[$i] : [];
            $mei[] = $rekrutmen_record[$i] == "05" ? $rekrutmen_record[$i] : [];
            $juni[] = $rekrutmen_record[$i] == "06" ? $rekrutmen_record[$i] : [];
            $juli[] = $rekrutmen_record[$i] == "07" ? $rekrutmen_record[$i] : [];
            $agust[] = $rekrutmen_record[$i] == "08" ? $rekrutmen_record[$i] : [];
            $sept[] = $rekrutmen_record[$i] == "09" ? $rekrutmen_record[$i] : [];
            $okt[] = $rekrutmen_record[$i] == "10" ? $rekrutmen_record[$i] : [];
            $nov[] = $rekrutmen_record[$i] == "11" ? $rekrutmen_record[$i] : [];
            $dec[] = $rekrutmen_record[$i] == "12" ? $rekrutmen_record[$i] : [];
        endif;
    endfor;

    if (count($rekrutmen_record) > 0) {
        $chart_rekrut = [
            count(array_filter($jan)),
            count(array_filter($feb)),
            count(array_filter($maret)),
            count(array_filter($april)),
            count(array_filter($mei)),
            count(array_filter($juni)),
            count(array_filter($juli)),
            count(array_filter($agust)),
            count(array_filter($sept)),
            count(array_filter($okt)),
            count(array_filter($nov)),
            count(array_filter($dec))
        ];
    }

    return $chart_rekrut;
}

function getDataStatusKaryawan($data_karyawan)
{
    $data_pkwtt = [];
    $data_pkwt = [];
    $data_training = [];

    foreach ($data_karyawan as $data) {
        if ($data->status_karyawan == 'PKWTT') {
            $data_pkwtt[] = [
                'nik' => $data->nik
            ];
        }
        if ($data->status_karyawan == 'PKWT') {
            $data_pkwt[] = [
                'nik' => $data->nik
            ];
        }
        if ($data->status_karyawan == 'TRAINING') {
            $data_training[] = [
                'nik' => $data->nik
            ];
        }
    }

    $datas = [
        count($data_pkwtt),
        count($data_pkwt),
        count($data_training),
    ];

    return $datas;
}

function getUmur($data_karyawan)
{
    $data1 = [];
    $data2 = [];
    $data3 = [];
    $data4 = [];
    $data5 = [];
    $data6 = [];
    $data7 = [];
    $data8 = [];
    $data9 = [];

    foreach ($data_karyawan as $d) {
        $birthDate = new DateTime($d->tgl_lahir);
        $hari_ini = new DateTime("today");
        $tahun = $hari_ini->diff($birthDate)->y;

        if ($tahun >= '18' && $tahun <= '22') {
            $data1[] = [
                'data1' => $tahun
            ];
        }
        if ($tahun >= '23' && $tahun <= '27') {
            $data2[] = [
                'data2' => $tahun
            ];
        }
        if ($tahun >= '28' && $tahun <= '32') {
            $data3[] = [
                'data3' => $tahun
            ];
        }
        if ($tahun >= '33' && $tahun <= '37') {
            $data4[] = [
                'data4' => $tahun
            ];
        }
        if ($tahun >= '38' && $tahun <= '42') {
            $data5[] = [
                'data5' => $tahun
            ];
        }
        if ($tahun >= '43' && $tahun <= '47') {
            $data6[] = [
                'data6' => $tahun
            ];
        }
        if ($tahun >= '48' && $tahun <= '52') {
            $data7[] = [
                'data7' => $tahun
            ];
        }
        if ($tahun >= '53' && $tahun <= '58') {
            $data8[] = [
                'data8' => $tahun
            ];
        }
        if ($tahun >= '59') {
            $data9[] = [
                'data9' => $tahun
            ];
        }
    }

    $datas = [
        count($data1),
        count($data2),
        count($data3),
        count($data4),
        count($data5),
        count($data6),
        count($data7),
        count($data8),
        count($data9),
    ];

    return $datas;
}

function getDataStatusKaryawanPersentase($data_karyawan)
{
    $data_pkwtt = [];
    $data_pkwt = [];
    $data_training = [];

    foreach ($data_karyawan as $data) {
        if ($data->status_karyawan == 'PKWTT') {
            $data_pkwtt[] = [
                'nik' => $data->nik
            ];
        }
        if ($data->status_karyawan == 'PKWT') {
            $data_pkwt[] = [
                'nik' => $data->nik
            ];
        }
        if ($data->status_karyawan == 'TRAINING') {
            $data_training[] = [
                'nik' => $data->nik
            ];
        }
    }

    $datas = [
        'pkwtt' => count($data_pkwtt),
        'pkwt' => count($data_pkwt),
        'training' => count($data_training),
    ];

    return $datas;
}

if (!function_exists('http_response_code')) {
    function http_response_code($code = NULL)
    {

        if ($code !== NULL) {

            switch ($code) {
                case 100:
                    $text = 'Continue';
                    break;
                case 101:
                    $text = 'Switching Protocols';
                    break;
                case 200:
                    $text = 'OK';
                    break;
                case 201:
                    $text = 'Created';
                    break;
                case 202:
                    $text = 'Accepted';
                    break;
                case 203:
                    $text = 'Non-Authoritative Information';
                    break;
                case 204:
                    $text = 'No Content';
                    break;
                case 205:
                    $text = 'Reset Content';
                    break;
                case 206:
                    $text = 'Partial Content';
                    break;
                case 300:
                    $text = 'Multiple Choices';
                    break;
                case 301:
                    $text = 'Moved Permanently';
                    break;
                case 302:
                    $text = 'Moved Temporarily';
                    break;
                case 303:
                    $text = 'See Other';
                    break;
                case 304:
                    $text = 'Not Modified';
                    break;
                case 305:
                    $text = 'Use Proxy';
                    break;
                case 400:
                    $text = 'Bad Request';
                    break;
                case 401:
                    $text = 'Unauthorized';
                    break;
                case 402:
                    $text = 'Payment Required';
                    break;
                case 403:
                    $text = 'Forbidden';
                    break;
                case 404:
                    $text = 'Not Found';
                    break;
                case 405:
                    $text = 'Method Not Allowed';
                    break;
                case 406:
                    $text = 'Not Acceptable';
                    break;
                case 407:
                    $text = 'Proxy Authentication Required';
                    break;
                case 408:
                    $text = 'Request Time-out';
                    break;
                case 409:
                    $text = 'Conflict';
                    break;
                case 410:
                    $text = 'Gone';
                    break;
                case 411:
                    $text = 'Length Required';
                    break;
                case 412:
                    $text = 'Precondition Failed';
                    break;
                case 413:
                    $text = 'Request Entity Too Large';
                    break;
                case 414:
                    $text = 'Request-URI Too Large';
                    break;
                case 415:
                    $text = 'Unsupported Media Type';
                    break;
                case 500:
                    $text = 'Internal Server Error';
                    break;
                case 501:
                    $text = 'Not Implemented';
                    break;
                case 502:
                    $text = 'Bad Gateway';
                    break;
                case 503:
                    $text = 'Service Unavailable';
                    break;
                case 504:
                    $text = 'Gateway Time-out';
                    break;
                case 505:
                    $text = 'HTTP Version not supported';
                    break;
                default:
                    exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
            }

            $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

            header($protocol . ' ' . $code . ' ' . $text);

            $GLOBALS['http_response_code'] = $code;
        } else {

            $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);
        }

        return $code;
    }
}

if (!function_exists('getNamaProvinsi')) {
    function getNamaProvinsi($id)
    {
        $name = Provinsi::where('id', $id)->first();
        if ($name === null) {
            $retval = "";
        } else {
            $retval = $name->provinsi;
        }
        return $retval;
    }
}

if (!function_exists('getNamaKecamatan')) {
    function getNamaKecamatan($id)
    {
        $name = Kecamatan::where('id', $id)->first();
        if ($name === null) {
            $retval = "";
        } else {
            $retval = $name->kecamatan;
        }
        return $retval;
    }
}

if (!function_exists('getJumlahPekerjaDaerah')) {
    function getJumlahPekerjaDaerah($data_karyawan)
    {
        $data = [];
        $morosi = [];
        $bondoala = [];
        $kapoiala = [];

        foreach ($data_karyawan as $d) {
            if (getNamaKecamatan($d->kecamatan_id) == 'MOROSI') {
                $morosi[] = [
                    'nama_provinsi' => getNamaKecamatan($d->kecamatan_id),
                ];
            }

            if (getNamaKecamatan($d->kecamatan_id) == 'BONDOALA') {
                $bondoala[] = [
                    'nama_provinsi' => getNamaKecamatan($d->kecamatan_id),
                ];
            }

            if (getNamaKecamatan($d->kecamatan_id) == 'KAPOIALA') {
                $kapoiala[] = [
                    'nama_provinsi' => getNamaKecamatan($d->kecamatan_id),
                ];
            }
        }
        $data = [
            'morosi' => count($morosi),
            'bondoala' => count($bondoala),
            'kapioala' => count($kapoiala),
        ];

        return $data;
    }
}

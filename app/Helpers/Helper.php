<?php

use App\Http\Controllers\Controller;
use App\Models\Departemen;
use App\Models\Divisi;
use App\Models\employee;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pengingat;
use App\Models\Provinsi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getName')) {
    function getName($id)
    {
        $nama = employee::where('nik', $id)->pluck('nama_karyawan')->implode("");
        return $nama;
    }
}

if (!function_exists('getNamaDivisi')) {
    function getNamaDivisi($id)
    {
        $nama = Divisi::where('id', $id)->pluck('nama_divisi')->implode("");
        return $nama;
    }
}

if (!function_exists('getNamaDepartemen')) {
    function getNamaDepartemen($id)
    {
        $nama = Departemen::where('id', $id)->pluck('departemen')->implode("");
        return $nama;
    }
}

if (!function_exists('getNamaProvinsi')) {
    function getNamaProvinsi($id)
    {
        $provinsi = Provinsi::where('id', $id)->pluck('provinsi')->implode("");
        return $provinsi;
    }
}

if (!function_exists('getNamaKabupaten')) {
    function getNamaKabupaten($id)
    {
        $kabupaten = Kecamatan::where('id', $id)->pluck('kabupaten')->implode("");
        return $kabupaten;
    }
}

if (!function_exists('getNamaKecamatan')) {
    function getNamaKecamatan($id)
    {
        $kecamatan = Kecamatan::where('id', $id)->pluck('kecamatan')->implode("");
        return $kecamatan;
    }
}

if (!function_exists('getNamaKelurahan')) {
    function getNamaKelurahan($key)
    {
        $data = Kelurahan::where('id', $key)->first();
        if ($data) {
            return $data->kelurahan;
        }
        return 'Tidak diketahui';
    }
}

if (!function_exists('getCountPengingat')) {
    function getCountPengingat()
    {
        $count_pengingat = [];
        $count_pengingat = Pengingat::where('flg_kirim', '1')->where('tanggal_cuti', '>', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('nik_karyawan', Auth::user()->employee->nik)->get();
        return $count_pengingat->count();
    }
}

if (!function_exists('getNotifPengingat')) {
    function getNotifPengingat()
    {
        $datas = [];
        $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->where('nik_karyawan', Auth::user()->employee->nik ?? '')->limit(4)->get();
        return $datas;
    }
}

if (!function_exists('getAllPengingat')) {
    function getAllPengingat()
    {
        $datas = [];
        $datas = Pengingat::orderBy('tanggal_cuti', 'ASC')->where('tanggal_cuti', '>', date('Y-m-d', strtotime(Carbon::now()->subDays(14)->toDateString())))->where('flg_kirim', '1')->get();
        return $datas;
    }
}

if (!function_exists('getDataResign')) {
    function getDataResign($karyawan_resign, $tahun_sekarang)
    {
        $resign_record = [];
        $validation1 = [];
        $jan = [];
        $feb = [];
        $maret = [];
        $april = [];
        $mei = [];
        $juni = [];
        $juli = [];
        $agust = [];
        $sept = [];
        $okt = [];
        $nov = [];
        $dec = [];
        $chart_resign = '';

        foreach ($karyawan_resign as $ks) {
            $validation1[] = date('Y', strtotime($ks->tgl_resign));
        }

        foreach ($karyawan_resign as $ks) {
            $resign_record[] = date('m-d', strtotime($ks->tgl_resign));
        }


        for ($i = 0; $i < count($resign_record); $i++) :
            if ($validation1[$i] == $tahun_sekarang) :
                if ($resign_record[$i] >= '01-16' && $resign_record[$i] <= '02-15') {
                    $jan[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '02-16' && $resign_record[$i] <= '03-15') {
                    $feb[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '03-16' && $resign_record[$i] <= '04-15') {
                    $maret[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '04-16' && $resign_record[$i] <= '05-15') {
                    $april[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '05-16' && $resign_record[$i] <= '06-15') {
                    $mei[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '06-16' && $resign_record[$i] <= '07-15') {
                    $juni[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '07-16' && $resign_record[$i] <= '08-15') {
                    $juli[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '08-16' && $resign_record[$i] <= '09-15') {
                    $agust[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '09-16' && $resign_record[$i] <= '10-15') {
                    $sept[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '10-16' && $resign_record[$i] <= '11-15') {
                    $okt[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '11-16' && $resign_record[$i] <= '12-15') {
                    $nov[] = $resign_record[$i];
                }

                if ($resign_record[$i] >= '12-15' && $resign_record[$i] <= '01-15' && $tahun_sekarang == $validation1[$i]) {
                    $dec[] = $resign_record[$i];
                }
            endif;
        endfor;

        if (count($resign_record) > 0) {
            $chart_resign = [
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

        return $chart_resign;
    }
}

if (!function_exists('getDataStatus')) {
    function getDataStatus($status_karyawan)
    {
        $data_status = array();
        $mutasi = array();
        $resign = array();
        $phk = array();
        $efisiensi = array();
        $pengembalian = array();

        foreach ($status_karyawan as $row) {

            $data_status[] = [
                'status' => $row->status_resign,
                'tanggal' => $row->tgl_resign
            ];
        }

        for ($i = 0; $i < count($data_status); $i++) {

            $mutasi[] = $data_status[$i]['status'] == "Mutasi" ? $data_status[$i]['status'] : [];

            $resign[] = $data_status[$i]['status'] == "Resign" ? $data_status[$i]['status']
                : ($data_status[$i]['status'] == "BAIK" ? $data_status[$i]['status']
                    : ($data_status[$i]['status'] == "KABUR" ? $data_status[$i]['status']
                        : ($data_status[$i]['status'] == "PASAL (50)" ? $data_status[$i]['status']
                            : ($data_status[$i]['status'] == "PB RESIGN" ? $data_status[$i]['status']
                                : ($data_status[$i]['status'] == "PUTUS KONTRAK" ? $data_status[$i]['status'] : [])))));

            $phk[] = $data_status[$i]['status'] == "PHK" ? $data_status[$i]['status'] : [];
            $efisiensi[] = $data_status[$i]['status'] == "Efisiensi" ? $data_status[$i]['status'] : [];
            $pengembalian[] = $data_status[$i]['status']  == "Pengembalian" ? $data_status[$i]['status'] : [];
        }

        $chart_status_karyawan = [
            count(array_filter($mutasi)),
            count(array_filter($resign)),
            count(array_filter($phk)),
            count(array_filter($efisiensi)),
            count(array_filter($pengembalian)),
        ];

        return $chart_status_karyawan;
    }
}

if (!function_exists('getDataRekrut')) {
    function getDataRekrut($data_contract, $tahun_sekarang)
    {
        $rekrutmen_record = [];
        $validation = [];
        $jan = [];
        $feb = [];
        $maret = [];
        $april = [];
        $mei = [];
        $juni = [];
        $juli = [];
        $agust = [];
        $sept = [];
        $okt = [];
        $nov = [];
        $dec = [];
        $chart_rekrut = '';

        foreach ($data_contract as $d) {
            $validation[] = date('Y', strtotime($d->tanggal_mulai_kontrak));
        }

        foreach ($data_contract as $d) {
            $rekrutmen_record[] = date('m-d', strtotime($d->tanggal_mulai_kontrak));
        }

        for ($i = 0; $i < count($rekrutmen_record); $i++) :

            if ($validation[$i] == $tahun_sekarang) :
                if ($rekrutmen_record[$i] >= '01-16' && $rekrutmen_record[$i] <= '02-15') {
                    $jan[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '02-16' && $rekrutmen_record[$i] <= '03-15') {
                    $feb[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '03-16' && $rekrutmen_record[$i] <= '04-15') {
                    $maret[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '04-16' && $rekrutmen_record[$i] <= '05-15') {
                    $april[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '05-16' && $rekrutmen_record[$i] <= '06-15') {
                    $mei[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '06-16' && $rekrutmen_record[$i] <= '07-15') {
                    $juni[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '07-16' && $rekrutmen_record[$i] <= '08-15') {
                    $juli[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '08-16' && $rekrutmen_record[$i] <= '09-15') {
                    $agust[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '09-16' && $rekrutmen_record[$i] <= '10-15') {
                    $sept[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '10-16' && $rekrutmen_record[$i] <= '11-15') {
                    $okt[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '11-16' && $rekrutmen_record[$i] <= '12-15') {
                    $nov[] = $rekrutmen_record[$i];
                }

                if ($rekrutmen_record[$i] >= '12-16' && $rekrutmen_record[$i] <= '01-15' && $tahun_sekarang == $validation[$i]) {
                    $dec[] = $rekrutmen_record[$i];
                }
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
}

if (!function_exists('getDataStatusKaryawan')) {
    function getDataStatusKaryawan($data_karyawan)
    {
        $data_pkwtt = [];
        $data_pkwt = [];
        $data_training = [];

        foreach ($data_karyawan as $data) {
            if ($data->status_karyawan == 'PKWTT 固定工') {
                $data_pkwtt[] = [
                    'nik' => $data->nik
                ];
            }
            if ($data->status_karyawan == 'PKWT 合同工') {
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
}

if (!function_exists('getUmur')) {
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
            if ($tahun >= '53' && $tahun <= '57') {
                $data8[] = [
                    'data8' => $tahun
                ];
            }
            if ($tahun >= '58') {
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
}

if (!function_exists('getDataStatusKaryawanPersentase')) {
    function getDataStatusKaryawanPersentase($data_karyawan)
    {
        $data_pkwtt = [];
        $data_pkwt = [];
        $data_training = [];

        foreach ($data_karyawan as $data) {
            if ($data->status_karyawan == 'PKWTT 固定工') {
                $data_pkwtt[] = [
                    'nik' => $data->nik
                ];
            }
            if ($data->status_karyawan == 'PKWT 合同工') {
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
}

if (!function_exists('getJumlahPekerjaByKelurahan')) {
    function getJumlahPekerjaByKelurahan($kelurahan)
    {
        $data = [];
        $array = $kelurahan;
        $array = array_replace($array, array_fill_keys(array_keys($array, null), ''));
        $counted = array_count_values($array);

        arsort($counted);

        foreach ($counted as $key => $val) {

            $data[] = [
                'id' => $key == "" ? 'Tidak diketahui' : $key,
                'kelurahan' => Kelurahan::where('id', $key)->pluck('kelurahan')->implode(''),
                'total' => $val,
            ];
        }
        return $data;
    }
}

if (!function_exists('jumlahPekerjaByKelurahan')) {
    function jumlahPekerjaByKelurahan($data)
    {
        for ($i = 0; $i < $data; $i++) {
            $total_pekerja[] = isset($data[$i]['total']) == true ? $data[$i]['total'] : 0;

            if ($i == 4)
                break;
        }
        return $total_pekerja;
    }
}

if (!function_exists('daftarNamaKelurahan')) {
    function daftarNamaKelurahan($data)
    {
        for ($i = 0; $i < $data; $i++) {
            $nama_kelurahan[] = isset($data[$i]['kelurahan']) == true ? $data[$i]['kelurahan'] : 0;

            if ($i == 4)
                break;
        }
        return $nama_kelurahan;
    }
}

if (!function_exists('jmlHariMinggu')) {
    function jmlHariMinggu($start, $end)
    {
        $date1 = $start;
        $date2 = $end;
        // memecah bagian-bagian dari tanggal $date1
        $pecahTgl1 = explode("-", $date1);

        // membaca bagian-bagian dari $date1
        $tgl1 = $pecahTgl1[0];
        $bln1 = $pecahTgl1[1];
        $thn1 = $pecahTgl1[2];

        // counter looping
        $i = 0;

        // counter untuk jumlah hari minggu
        $sum = 0;

        do {
            // mengenerate tanggal berikutnya
            $tanggal = date("d-m-Y", mktime(0, 0, 0, $bln1, $tgl1 + $i, $thn1));

            // cek jika harinya minggu, maka counter $sum bertambah satu, lalu tampilkan tanggalnya
            if (date("w", mktime(0, 0, 0, $bln1, $tgl1 + $i, $thn1)) == 0) {
                $sum++;
                echo $tanggal . "<br>";
            }
            // increment untuk counter looping
            $i++;
        } while ($tanggal != $date2);

        // looping di atas akan terus dilakukan selama tanggal yang digenerate tidak sama dengan $date2.

        // tampilkan jumlah hari Minggu
        return $sum;
    }
}

if (!function_exists('first')) {
    function first($array)
    {
        $counter = 0;

        // Loop starts from here
        foreach ($array as $item) {

            // Check condition if count is 0 then 
            // it is the first iteration
            if ($counter == 0) {

                return $item;
            }

            if ($counter == count($array) - 1) {

                // Print the array content
                print($item);
                print(": Last iteration");
            }

            $counter = $counter + 1;
        }
    }
}

if (!function_exists('last')) {
    function last($array)
    {
        $counter = 0;
        // Loop starts from here
        foreach ($array as $item) {

            if ($counter == count($array) - 1) {

                return $item;
            }

            $counter = $counter + 1;
        }
    }
}

if (!function_exists('mealAllowance')) {
    function mealAllowance($data, $attendance)
    {
        $meal_allowance = $data->tunj_makan * count($attendance);
        return $meal_allowance;
    }
}

if (!function_exists('dailySalary')) {
    function dailySalary($data, $attendance)
    {
        $daily_salary = $data->gaji_pokok / $data->jumlah_hari_kerja;
        $daily_salary = $daily_salary * count($attendance);
        return $daily_salary;
    }
}

if (!function_exists('tgl_indo')) {
    function tgl_indo($tanggal)
    {
        if (isset($tanggal)) {
            $bulan = array(
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            // variabel pecahkan 0 = tanggal
            // variabel pecahkan 1 = bulan
            // variabel pecahkan 2 = tahun

            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        }
        return '';
    }
}

if (!function_exists('bulan_romawi')) {
    function bulan_romawi($bln)
    {
        switch ($bln) {

            case '1':
                return "I";
                break;
            case '2':
                return "II";
                break;
            case '3':
                return "III";
                break;
            case '4':
                return "IV";
                break;
            case '5':
                return "V";
                break;
            case '6':
                return "VI";
                break;
            case '7':
                return "VII";
                break;
            case '8':
                return "VIII";
                break;
            case '9':
                return "IX";
                break;
            case '10':
                return "X";
                break;
            case '11':
                return "XI";
                break;
            case '12':
                return "XII";
                break;
        }
    }
}

if (!function_exists('no_urut_surat')) {
    function no_urut_surat($nomor)
    {
        $nomor += 1;
        if (strlen($nomor) == '1') {
            return  '000' . $nomor;
        }
        if (strlen($nomor) == '2') {
            return '00' . $nomor;
        }
        if (strlen($nomor) == '3') {
            return '0' . $nomor;
        }
        if (strlen($nomor) == '3') {
            return $nomor;
        }
    }
}

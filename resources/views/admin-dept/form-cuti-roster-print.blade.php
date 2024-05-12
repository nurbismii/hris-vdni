<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <meta charset="utf-8" /> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>FORMULIR PERMOHONAN CUTI ROSTER 休假申请单</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    @font-face {
      font-family: 'Times New Roman';
      font-style: normal;
      font-weight: 600;
      src: url('https://eclecticgeek.com/dompdf/fonts/cjk/fireflysung.ttf') format('truetype');
    }

    * {
      font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif, sans-serif;
      font-size: 11px;
      font-weight: 600;
    }

    /* Thick red border */
    hr.new4 {
      border: 0.2px solid black;
    }

    .justify {
      text-align: justify;
    }

    table,
    th,
    td {
      border: 1px solid;
    }
  </style>
</head>

<body class="nav-fixed">
  <div id="layoutSidenav">
    <main>
      <!-- Main page content-->
      <div class="container-xl px-1">
        <div class="text-center">FORMULIR PERMOHONAN CUTI ROSTER 休假申请单<br>
          Nomor 编号 : {{ $data->nomor_surat ?? '' }}
        </div>
        <img class="text-start" src="{{ public_path('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 40px;" alt="">

        <div class="card-body">
          <div class="table-responsive">
            <table style="width: 100%;">
              <tbody>
                <tr>
                  <th colspan="10" class="font-weight-bold">I. DATA KARYAWAN 个人信息</th>
                </tr>
                <tr>
                  <td>Nama 姓名</td>
                  <td colspan="2">{{ $data->nama_karyawan }}</td>
                  <td>Tanggal Pengajuan 申请日期</td>
                  <td colspan="6">{{ tgl_indo($data->tanggal_pengajuan) }}</td>
                </tr>
                <tr>
                  <td>NIK工号</td>
                  <td colspan="2">{{ $data->nik }}</td>
                  <td>Nomor HP 手机号</td>
                  <td colspan="6">{{ $data->no_telp }}</td>
                </tr>
                <tr>
                  <td>Posisi 岗位</td>
                  <td colspan="2">{{ $data->posisi }}</td>
                  <td>Email 邮件地址</td>
                  <td colspan="6">{{ $data->user->email ?? '' }}</td>
                </tr>
                <tr>
                  <th class="text-center" colspan="10">PERIODE ROSTER SAAT INI 目前休假明细</th>
                </tr>
                <tr>
                  <th class="text-center" colspan="10">Tanggal Periode Kerja Roster <br> 工作日期</th>
                </tr>
                <tr>
                  <th class="text-center" colspan="10">{{ tgl_indo($data->periode_awal) }} - {{ tgl_indo($data->periode_akhir) }} </th>
                </tr>
                <tr class="text-center">
                  <th style="width: 20%;" rowspan="3">OFF 休息日</th>
                  <td colspan="1" style="width: 16%;">I</td>
                  <td colspan="1" style="width: 16%;">II</td>
                  <td colspan="1" style="width: 16%;">III</td>
                  <td style="width: 9rem;">IV</td>
                  <td style="width: 80rem;" colspan="5">V</td>
                </tr>
                <tr class="text-center">
                  <td colspan="1">{{ $data->satu }}</td>
                  <td colspan="1">{{ $data->dua }}</td>
                  <td colspan="1">{{ $data->tiga }}</td>
                  <td style="width: 20%;">{{ $data->empat }}</td>
                  <td colspan="5">{{ $data->lima }}</td>
                </tr>
                <tr class="text-center">
                  <td colspan="1">{{ $data->tanggal_satu }}</td>
                  <td colspan="1">{{ $data->tanggal_dua }}</td>
                  <td colspan="1">{{ $data->tanggal_tiga }}</td>
                  <td>{{ $data->tanggal_empat }}</td>
                  <td colspan="5">{{ $data->tanggal_lima }}</td>
                </tr>
                <tr>
                  <th class="text-center" colspan="10">RENCANA PADA MASA PERIODE ISTIRAHAT ROSTER 休假期的计划</th>
                </tr>
                <tr class="text-center">
                  <td colspan="1">Jenis Pilihan 选择</td>
                  <td colspan="2">Pilihan (√) 选择栏</td>
                  <td colspan="7">Alasan 原因</td>
                </tr>
                <tr class="text-center">
                  <td colspan="1">Cuti 轮休假</td>
                  <td colspan="2">
                    @if($data->tipe_rencana == '1')
                    &radic;
                    @endif
                  </td>
                  <td colspan="7">
                    @if($data->tipe_rencana == '1')
                    {{$data->alasan}}
                    @endif
                  </td>
                </tr>
                <tr class="text-center">
                  <td colspan="1">Bekerja 工作</td>
                  <td colspan="2">
                    @if($data->tipe_rencana == '2')
                    &radic;
                    @endif
                  </td>
                  <td colspan="7">
                    @if($data->tipe_rencana == '2')
                    {{$data->alasan}}
                    @endif
                  </td>
                </tr>
                <tr>
                  <th colspan="10">II. a @if($data->tipe_rencana == '1') &radic; @endif PENGAJUAN CUTI 申请休假</th>
                </tr>
                <tr class="text-center">
                  <td>Jenis Cuti 休假类型</td>
                  <td colspan="4">Periode Tanggal Cuti 休假日期</td>
                  <td colspan="5">Total Hari Cuti 休假总数（天）</td>
                </tr>
                <tr class="text-center">
                  <td>Cuti Roster 轮休假</td>
                  <td colspan="4">{{ tgl_indo($data->tgl_mulai_cuti) }} - {{ tgl_indo($data->tgl_mulai_cuti_berakhir) }}</td>
                  @php
                  $tgl1 = strtotime($data->tgl_mulai_cuti);
                  $tgl2 = strtotime($data->tgl_mulai_cuti_berakhir);
                  $selisih =$tgl2 - $tgl1;
                  $hari = $selisih / 60 / 60 / 24;
                  @endphp
                  <td colspan="5">{{ $hari + 1 }}</td>
                </tr>
                <tr class="text-center">
                  <td>Cuti Tahunan 年假</td>
                  <td colspan="4">{{ tgl_indo($data->tgl_mulai_cuti_tahunan) }} - {{ tgl_indo($data->tgl_mulai_cuti_tahunan_berakhir) }}</td>
                  @php
                  $tgl1 = strtotime($data->tgl_mulai_cuti_tahunan);
                  $tgl2 = strtotime($data->tgl_mulai_cuti_tahunan_berakhir);
                  $selisih =$tgl2 - $tgl1;
                  $hari = $selisih / 60 / 60 / 24;
                  @endphp
                  <td colspan="5">{{ $hari + 1 }}</td>
                </tr>
                <tr class="text-center">
                  <td>OFF 休息日</td>
                  <td colspan="4">{{ tgl_indo($data->tgl_mulai_off) }} - {{ tgl_indo($data->tgl_mulai_off_berakhir) }}</td>
                  @php
                  $tgl1 = strtotime($data->tgl_mulai_off);
                  $tgl2 = strtotime($data->tgl_mulai_off_berakhir);
                  $selisih =$tgl2 - $tgl1;
                  $hari = $selisih / 60 / 60 / 24;
                  @endphp
                  <td colspan="5">{{ $hari + 1 }}</td>
                </tr>
                <tr>
                  <th class="text-center" colspan="10">Detail Pemesanan Tiket Pesawat Detail Pemesanan Tiket Pesawat 飞机票预订详情</th>
                </tr>
                <tr>
                  <td class="text-center" colspan="3">Keberangkatan 出港</td>
                  <td class="text-center" colspan="7">Kepulangan 到达</td>
                </tr>
                <tr>
                  <td>Tanggal</td>
                  <td class="text-center" colspan="2">{{ tgl_indo($data->tgl_keberangkatan) }}</td>
                  <td>Tanggal</td>
                  <td class="text-center" colspan="6">{{ tgl_indo($data->tgl_kepulangan) }}</td>
                </tr>
                <tr>
                  <td>Waktu</td>
                  <td class="text-center" colspan="2">Pukul {{ $data->jam_keberangkatan }}</td>
                  <td>Waktu</td>
                  <td class="text-center" colspan="6">Pukul {{ $data->jam_kepulangan }}</td>
                </tr>
                <tr>
                  <td>Dari</td>
                  <td class="text-center" colspan="2">{{ $data->kota_awal_keberangkatan }}</td>
                  <td>Dari</td>
                  <td class="text-center" colspan="6">{{ $data->kota_awal_kepulangan }}</td>
                </tr>
                <tr>
                  <td>Tujuan</td>
                  <td class="text-center" colspan="2">{{ $data->kota_awal_kepulangan }}</td>
                  <td>Tujuan</td>
                  <td class="text-center" colspan="6">{{ $data->kota_tujuan_kepulangan }}</td>
                </tr>
                <tr>
                  <td class="text-center" colspan="3">Catatan penting</td>
                  <td class="text-center" colspan="7">Catatan penting</td>
                </tr>
                <tr>
                  @if($data->catatan_penting_keberangkatan)
                  <td class="text-center" colspan="3">{{ $data->catatan_penting_keberangkatan }}</td>
                  @endif
                  @if($data->catatan_penting_kepulangan)
                  <td class="text-center" colspan="7">{{ $data->catatan_penting_kepulangan }}</td>
                  @endif
                  @if(!$data->catatan_penting_keberangkatan && !$data->catatan_penting_kepulangan)
                  <td class="text-center" colspan="3"><br></td>
                  <td class="text-center" colspan="7"><br></td>
                  @endif
                </tr>
                <tr>
                  <th colspan="10">II.b @if($data->tipe_rencana == '2') &radic; @endif WAKTU KERJA 工作时间</th>
                </tr>
                <tr>
                  <td class="text-center" colspan="4">Tanggal Bekerja pada Periode Cuti Roster 在轮休假期工作日期</td>
                  <td class="text-center" colspan="6">Total Hari Bekerja 在轮休假期来工作总数（天）</td>
                </tr>
                <tr>
                  @if($data->tipe_rencana == '2')
                  @php
                  $tgl_cuti = new DateTime($data->tgl_awal_kerja);
                  $tgl_sekarang = new DateTime($data->tgl_akhir_kerja);
                  $tgl_jt_tempo = $tgl_sekarang->diff($tgl_cuti)->days;
                  @endphp
                  <td class="text-center" colspan="4">{{ tgl_indo($data->tgl_awal_kerja) }} - {{ tgl_indo($data->tgl_akhir_kerja) }}</td>
                  <td class="text-center" colspan="6">{{ $tgl_jt_tempo + 1}}</td>
                  @else
                  <td class="text-center" colspan="4">-</td>
                  <td class="text-center" colspan="6">-</td>
                  @endif
                </tr>
                <tr>
                  <td class="text-center" colspan="2" rowspan="2">Pemohon 申请人</td>
                  <td class="text-center" colspan="2">Disetujui 批准</td>
                  <td class="text-center" colspan="6">Diketahui 知悉</td>
                </tr>
                <tr>
                  <td class="text-center" colspan="2">HOD 部门负责人</td>
                  <td class="text-center" colspan="6">HRD 人事部门</td>
                </tr>
                <tr>
                  <td colspan="2">
                    <br><br><br>
                  </td>
                  <td colspan="2"></td>
                  <td colspan="6"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>
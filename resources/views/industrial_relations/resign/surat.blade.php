<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <meta charset="utf-8" /> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Collective agreement</title>

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
      font-size: 12px;
      font-weight: 600;
    }

    /* Thick red border */
    hr.new4 {
      border: 0.2px solid black;
    }

    .justify {
      text-align: justify;
    }
  </style>
</head>

<body class="nav-fixed">
  <div id="layoutSidenav">
    <main>
      <!-- Main page content-->
      <div class="container-xl px-1">
        <div class="text-end mb-2">
          <img src="{{ public_path('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 40px;" alt=""><br>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table style="width: 100%;">
              <tbody>
                <tr>
                  <td style="width: 12%;">Nomor</td>
                  <td style="width: 2%;">:</td>
                  <td colspan="3">{{ $data->no_surat }}</td>
                </tr>
                <tr>
                  <td>Lampiran</td>
                  <td>:</td>
                  <td colspan="3">1 (satu) berkas</td>
                </tr>
                <tr>
                  <td>Perihal</td>
                  <td>:</td>
                  <td colspan="3">Surat Keterangan Tidak Memperpanjang Kontrak Kerja</td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td></td>
                  <td colspan="2"></td>
                  <td></td>
                  <td>Kepada Yth, <br>
                    Saudara(i) {{$data->nama_karyawan}} <br>
                    Di<br>
                    <p class="p-2">Tempat</p>
                  </td>
                </tr>
                <tr>
                  <td colspan="5">
                    <div class="d-flex justify-content-between">
                      Yang bertanda tangan dibawah ini :
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td colspan="3">AHMAD SAEKUZEN</td>
                </tr>
                <tr>
                  <td>Jabatan</td>
                  <td>:</td>
                  <td colspan="3">HRD MANAGER</td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <div class="d-flex justify-content-between">
                      Dengan ini menerangkan bahwa :
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td>Nama</td>
                  <td>:</td>
                  <td colspan="3">ISHAK</td>
                </tr>
                <tr>
                  <td>Jabatan</td>
                  <td>:</td>
                  <td colspan="3">{{ $data->posisi }}</td>
                </tr>
                <tr>
                  <td>NIK</td>
                  <td>:</td>
                  <td colspan="3">{{ $data->nik_karyawan }}</td>
                </tr>
                <tr>
                  <td colspan="5">
                    <div class="d-flex justify-content-between">
                      Bahwa berdasarkan data/catatan kami, kontrak kerja saudara akan berakhir pada tanggal, {{ tgl_indo($data->tanggal_keluar) }}, dan atas hal itu, managemen perusahaan telah memutuskan untuk TIDAK MEMPERPANJANG KONTRAK KERJA saudara sesuai dengan surat Penilaian Kinerja Karyawan yang dibuat dan ditanda tangani oleh HOD.
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <div class="d-flex justify-content-between">
                      Dengan berakhirnya jangka waktu kontrak kerja, maka secara hukum kontrak kerja saudara juga telah berakhir dengan sendirinya;
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5" rowspan="1"></td>
                </tr>
                <tr>
                  <td colspan="5">
                    <div class="d-flex justify-content-between">
                      Demikian surat keterangan ini disampaikan kepada yang bersangkutan untuk diketahui dan atas pengabdiannya selama ini pada perusahaan, kami ucapkan terima kasih.
                    </div>
                  </td>
                </tr>
                <br><br><br><br>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1"></td>
                  <td style="text-align: center;">Tanggal</td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1"></td>
                  <td style="text-align: center;">HRD Manager</td>
                </tr>
                <br><br><br><br><br>
                <tr>
                  <td colspan="3"></td>
                  <td colspan="1"></td>
                  <td style="text-align: center;">AHMAD SAEKUZEN</td>
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
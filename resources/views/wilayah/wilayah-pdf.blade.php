<!DOCTYPE html>
<html lang="en">

<head>
  <!-- <meta charset="utf-8" /> -->
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Slip Gaji</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    @font-face {
      font-family: 'Firefly Sung';
      font-style: normal;
      font-weight: 600;
      src: url('https://eclecticgeek.com/dompdf/fonts/cjk/fireflysung.ttf') format('truetype');
    }

    * {
      font-family: Firefly Sung, DejaVu Sans, sans-serif;
      font-size: 12px;
    }

    th,
    td {
      border: 0.5px solid;
    }
  </style>
</head>

<body class="nav-fixed">
  <div id="layoutSidenav">
    <main>
      <!-- Main page content-->
      <div class="container-xl px-1">
        <!-- Invoice-->
        <div class="card invoice">
          <div class="card-body p-4 p-md-5">
            <!-- Invoice table-->
            <b>HASIL LAPORAN WILAYAH :</b>
            <div class="p-3">
              <table class="table table-bordered">
                <tr>
                  <th width="30%">Area kerja</th>
                  <td width="5px">:</td>
                  <td>PT {{ $area }}</td>
                </tr>
                <tr>
                  <th width="30%">Provinsi</th>
                  <td width="5px">:</td>
                  <td>{{ getNamaProvinsi($provinsi_id) }}</td>
                </tr>
                <tr>
                  <th>Kabupaten</th>
                  <td>:</td>
                  <td>{{ getNamaKabupaten($kabupaten_id) }}</td>
                </tr>
                <tr>
                  <th>Kecamatan</th>
                  <td>:</td>
                  <td>{{ getNamaKecamatan($kecamatan_id) }}</td>
                </tr>
                <tr>
                  <th>Jumlah kelurahan/desa</th>
                  <td>:</td>
                  <td>{{ count($response) }}</td>
                </tr>
              </table>
              <table id="datatablesSimpleWilayah" class="table table-bordered">
                <thead>
                  <tr>
                    <th>Daftar kelurahan/desa</th>
                    <th>Total karyawan</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $totalKaryawan = 0;
                  $no = 1;
                  @endphp
                  @foreach($response as $item)
                  <tr>

                    <td>
                      @if($item['kelurahan_id'])
                      {{ getNamaKelurahan($item['kelurahan_id']) }}
                      @else
                      BELUM DIKETAHUI
                      @endif
                    </td>

                    <td width="25%">
                      {{ $item['jumlah_karyawan'] }}
                    </td>

                    @if($item['kelurahan_id'])
                    @php $totalKaryawan += $item['jumlah_karyawan']; @endphp
                    @endif

                  </tr>
                  @endforeach
                  <tr>
                    <th colspan="1" class="fw-800">Total karyawan kecamatan</th>
                    <td class="fw-800">{{ $totalKaryawan }} </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </main>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>
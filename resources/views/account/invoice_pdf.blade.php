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
            font-weight: 400;
            src: url('https://eclecticgeek.com/dompdf/fonts/cjk/fireflysung.ttf') format('truetype');
        }

        * {
            font-family: Firefly Sung, DejaVu Sans, sans-serif;
            font-size: 11px;
        }

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
                <!-- Invoice-->
                <div class="card invoice">
                    <div class="text-center">
                        <h4 class="fw-bold">PT VDNI</h4>
                        <img src="{{ public_path('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;" alt=""><br>
                        <span class="fw-normal">SLIP GAJI </span> <br>
                        <span class="fw-normal"> Periode ({{ date('F Y', strtotime($data->mulai_periode)) }} - {{ date('F Y', strtotime($data->akhir_periode)) }})</span>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <!-- Invoice table-->
                        <div class="table-responsive">
                            <table class="table table-borderless mb-3">
                                <tbody>
                                    <tr>
                                        <td scope="row">NIK Karyawan</td>
                                        <td>{{ $data->employee_id }}</td>
                                        <td>Total Hari Kerja</td>
                                        <td>{{ $data->jumlah_hari_kerja }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Nama Karyawan</td>
                                        <td>{{ $karyawan->nama_karyawan }}</td>
                                        <td>Status Gaji</td>
                                        <td>{{ ucfirst($data->status_gaji) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Departemen</td>
                                        <td>{{ $karyawan->divisi->departemen->departemen }}</td>
                                        <td>Divisi</td>
                                        <td>{{ $karyawan->divisi->nama_divisi }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Posisi</td>
                                        <td>{{ $data->posisi }}</td>
                                        <td>Hour Machine</td>
                                        <td>{{ $data->jumlah_hour_machine }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead class="border-bottom">
                                    <tr class="small text-uppercase text-muted">
                                        <th scope="col">Detail</th>
                                        <th class="text-end" scope="col">Jumlah</th>
                                        <th class="text-end" scope="col">Deduction</th>
                                        <th class="text-end" scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="">
                                        @if($data->gaji_pokok > 0)
                                        <td>
                                            <div class="">Gaji pokok</div>
                                        </td>
                                        <td class="text-end">Rp{{ number_format($data->gaji_pokok, 0, ",", ".") }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->jht > 0)
                                        <td class="text-end ">BPJS TK JHT</td>
                                        <td class="text-end ">Rp{{ number_format($data->jht, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <!-- Invoice item 2-->
                                    <tr class="">
                                        @if($data->tunjangan_umum > 0)
                                        <td>
                                            <div class="">Tunj. Uang Makan</div>
                                        </td>
                                        <td class="text-end ">Rp{{ number_format($data->tunjangan_umum, 0, ",", ".")  }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->jp > 0)
                                        <td class="text-end ">BPJS TK JP</td>
                                        <td class="text-end ">Rp{{ number_format($data->jp, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <!-- Invoice item 3-->
                                    <tr class="">
                                        @if($data->tunjangan_pengawas > 0)
                                        <td>
                                            <div class="">Tunj. Pengawas</div>
                                        </td>
                                        <td class="text-end ">Rp{{ number_format($data->tunjangan_pengawas, 0, ",", ".")  }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->bpjs_kesehatan > 0)
                                        <td class="text-end ">BPSJ Kesehatan</td>
                                        <td class="text-end ">Rp{{ number_format($data->bpjs_kesehatan, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <!-- Invoice item 4-->
                                    <tr class="">
                                        @if($data->tunjungan_transportasi > 0)
                                        <td>
                                            <div class="">Tunj. Transportasi</div>
                                        </td>
                                        <td class="text-end ">Rp{{ number_format($data->tunjungan_transportasi, 0, ",", ".")  }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->deduction_unpaid_leave > 0)
                                        <td class="text-end ">Deduction Unpaid Leave</td>
                                        <td class="text-end ">Rp{{ number_format($data->deduction_unpaid_leave, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <tr class="">
                                        @if($data->tunjugan_koefisien > 0)
                                        <td>
                                            <div class="">Tunj. Koefisien</div>
                                        </td>
                                        <td class="text-end ">Rp{{ number_format($data->tunjugan_koefisien, 0, ",", ".")  }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->deduction_unpaid_leave > 0)
                                        <td class="text-end ">Deduction Unpaid Leave</td>
                                        <td class="text-end ">Rp{{ number_format($data->deduction_unpaid_leave, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <tr class="">
                                        @if($data->tunjangan_mk > 0)
                                        <td>
                                            <div class="">Tunj. Masa Kerja</div>
                                        </td>
                                        <td class="text-end ">Rp{{ number_format($data->tunjangan_mk, 0, ",", ".")  }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->deduction > 0)
                                        <td class="text-end ">Deduction</td>
                                        <td class="text-end ">Rp{{ number_format($data->deduction, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <tr class="">
                                        @if($data->ot > 0)
                                        <td>
                                            <div class="">Lembur</div>
                                        </td>
                                        <td class="text-end">Rp{{ number_format($data->ot, 0, ",", ".")  }}</td>
                                        @else
                                        <td></td>
                                        <td></td>
                                        @endif
                                        @if($data->deduction_php21 > 0)
                                        <td class="text-end ">Deduction PPH 21</td>
                                        <td class="text-end ">Rp{{ number_format($data->deduction_php21, 0, ",", ".")  }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td class="text-end pb-0" colspan="3">
                                            <div class="text-uppercase small fw-700 text-muted">Total Penghasilan:</div>
                                        </td>
                                        <td class="text-end pb-0">
                                            <div class="h5 mb-0 fw-700">Rp{{ number_format($total_diterima, 0, ",", ".") }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end pb-0" colspan="3">
                                            <div class="text-uppercase small fw-700 text-muted">Total Deduction:</div>
                                        </td>
                                        <td class="text-end pb-0">
                                            <div class="h5 mb-0 fw-700">Rp{{ number_format($total_deduction, 0 , ",", ".") }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end pb-0" colspan="3">
                                            <div class="text-uppercase small fw-700 text-muted">Gaji Bersih:</div>
                                        </td>
                                        <td class="text-end pb-0">
                                            <div class="h5 mb-0 fw-700 text-green">Rp{{ number_format($gaji_bersih, 0, ",", ".") }}</div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="text-left">
                        <p class="mb-5 mx-4">Mengetahui,</p> <br> <br>
                        <p class="mt-3 mx-4">Payroll Sistem VDNi</p>
                    </div>

                </div>
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
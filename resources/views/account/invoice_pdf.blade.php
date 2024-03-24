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
    </style>
</head>

<body class="nav-fixed">
    <div id="layoutSidenav">
        <main>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-4">
                <!-- Invoice-->
                <div class="card invoice">
                    <div class="card-body p-2 p-md-4">
                        <div class="text-center lh-1 mb-2">
                            <h4 class="fw-bold">PT VDNI</h4> <br>
                            <img src="{{ public_path('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 50px;" alt=""><br> <br>
                            <span class="fw-normal mb-2"> Slip gaji </span> <br> <br>
                            <span class="fw-normal"> Periode ({{ date('F Y', strtotime($data->mulai_periode)) }} - {{ date('F Y', strtotime($data->akhir_periode)) }})</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Nomor Induk Karyawan</th>
                                        <td>{{ $check_exist->nik }}</td>
                                        <td>Jumlah hari kerja</td>
                                        <td>{{ $data->jml_hari_kerja }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Nama Karyawan</th>
                                        <td>{{ Auth::user()->employee->nama_karyawan }}</td>
                                        <td>Status Gaji</td>
                                        <td>{{ ucfirst($data->status_gaji) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Departemen</th>
                                        <td>{{ Auth::user()->employee->divisi->departemen->departemen }}</td>
                                        <td>Divisi</td>
                                        <td>{{ ucfirst(Auth::user()->employee->divisi->nama_divisi) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Posisi</th>
                                        <td>{{ $data->posisi }}</td>
                                        <td>Overtime</td>
                                        <td>{{ $data->ot }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Invoice table 1-->
                        <div class="row">
                            <div class="table-responsive col-lg-6">
                                <table class="table table-borderless mb-0">
                                    <thead class="border-bottom">
                                        <tr class="small text-uppercase text-muted">
                                            <th scope="col">Detail gaji</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($data->gaji_pokok > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Gaji Pokok</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->gaji_pokok, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_um > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Tunj. makan</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->tunj_um, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_pengawas > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Tunj. pengawas</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->tunj_pengawas) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_transport > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Tunj. Transportasi</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->tunj_transport) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_mk > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Tunj. masa kerja</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->tunj_mk) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_koefisien > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Tunj. koefisien</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->tunj_koefisien) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->ot > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Lembur</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->ot) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->jml_hour_machine > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Hour Machine</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->jml_hour_machine) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->rapel > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Rapel</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->rapel) }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <!-- Invoice table 2-->
                            <div class="table-responsive col-lg-6">
                                <table class="table table-borderless mb-0">
                                    <thead class="border-bottom">
                                        <tr class="small text-uppercase text-muted">
                                            <th scope="col">Deductions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($data->jht > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">BPJS TK JHT</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->jht, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->jp > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">BPJS TK JP</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->jp, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->pot_bpjskes > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">BPJS Kesehatan</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->pot_bpjskes) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->deduction > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">Deduction Unpaid Leave</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->deduction) }}</td>
                                        </tr>
                                        @endif
                                        @if($data->deduction_pph21 > 0)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="fw-bold">deduction PPH 21</div>
                                            </td>
                                            <td class="text-end fw-bold">:</td>
                                            <td class="text-end fw-bold">Rp.</td>
                                            <td class="text-end fw-bold">{{ number_format($data->deduction_pph21) }}</td>
                                        </tr>
                                        @endif
                                        @if($total_diterima > 0)
                                        <tr>
                                            <td class="text-end pb-0" colspan="3">
                                                <div class="text-uppercase small fw-700 text-muted">Total diterima :</div>
                                            </td>
                                            <td class="text-end pb-0">
                                                <div class="h5 mb-0 fw-700">Rp.{{ number_format($total_diterima, 0, ",",".") }}</div>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($total_deduction > 0)
                                        <tr>
                                            <td class="text-end pb-0" colspan="3">
                                                <div class="text-uppercase small fw-700 text-muted">Total deduction :</div>
                                            </td>
                                            <td class="text-end pb-0">
                                                <div class="h5 mb-0 fw-700 text-red"> - Rp.{{ number_format($total_deduction, 0, ",",".") }}</div>
                                            </td>
                                        </tr>
                                        @endif
                                        @if($gaji_bersih > 0)
                                        <tr>
                                            <td class="text-end pb-0" colspan="3">
                                                <div class="text-uppercase small fw-700 text-muted">Gaji bersih :</div>
                                            </td>
                                            <td class="text-end pb-0">
                                                <div class="h5 mb-0 fw-700 text-green">Rp.{{ number_format($gaji_bersih, 0, ",", ".") }}</div>
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer p-4 p-lg-5 border-top-0">
                        <div class="row">
                            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <!-- Invoice - sent to info-->
                                <div class="small text-muted text-uppercase fw-700 mb-2">Transfer kepada :</div>
                                <div class="h6 mb-1">{{ Auth::user()->employee->nama_karyawan }}</div>
                                <div class="small">PT VDNI</div>
                                <div class="small">Puuruy, Kec. Bondoala, Kabupaten Konawe, Sulawesi Tenggara 93354</div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <!-- Invoice - sent from info-->
                                <div class="small text-muted text-uppercase fw-700 mb-2">Payroll Sistem : </div>
                                <div class="h6 mb-1">PT VDNI</div>
                                <div class="small">Payroll</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>
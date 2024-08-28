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
            font-size: 12px;
        }

        .td.bet {
            border: 1px;
        }

        .row-bet {
            margin-left: -5px;
            margin-right: -5px;
        }

        .column-bet {
            float: left;
            width: 50%;
            padding: 5px;
        }

        /* Clearfix (clear floats) */
        .row-bet::after {
            content: "";
            clear: both;
            display: table;
        }

        .table-custom {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            border: 1px solid #ddd;
        }

        .td-bet {
            text-align: left;
            padding: 16px;
        }

        /* Tata letak responsif - membuat dua kolom bertumpuk, bukan bersebelahan pada layar yang lebih kecil dari 600 piksel */
        @media screen and (max-width: 600px) {
            .column-bet {
                width: 100%;
            }
        }

        hr.new4 {
            border: 0.5px #000;
        }
    </style>
</head>

<body class="nav-fixed">
    <div id="layoutSidenav">
        <main>
            <!-- Main page content-->
            <div class="container-xl">
                <!-- Invoice-->
                <div class="card invoice">
                    <div class="card-body">
                        <div class="text-center lh-1 mb-2">
                            <h4 class="fw-bold">PT VDNI</h4> <br>
                            <img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 50px;" alt=""><br> <br>
                            <span class="fw-normal mb-2"> Slip gaji </span> <br> <br>
                            <span class="fw-normal"> Periode ({{ date('F Y', strtotime($data->mulai_periode)) }} - {{ date('F Y', strtotime($data->akhir_periode)) }})</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td scope="row">Nomor Induk Karyawan</td>
                                        <td>{{ $data->nik }}</td>
                                        <td>Jumlah hari kerja</td>
                                        <td>{{ $data->jml_hari_kerja }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Nama Karyawan</td>
                                        <td>{{ $data->nama }}</td>
                                        <td>Status Gaji</td>
                                        <td>{{ ucfirst($data->status_gaji) }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Departemen</td>
                                        <td>{{ $data->departemen }}</td>
                                        <td>Divisi</td>
                                        <td>{{ $data->divisi }}</td>
                                    </tr>
                                    <tr>
                                        <td scope="row">Posisi</td>
                                        <td>{{ $data->posisi }}</td>
                                        <td>Overtime</td>
                                        <td>{{ $data->ot }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Invoice table 1-->
                        <div class="row-bet">
                            <div class="column-bet">
                                <table class="table mb-0">
                                    <thead class="border-bottom">
                                        <tr class="small text-uppercase text-muted">
                                            <td width="100px" class="text-start" scope="col">Rincian</td>
                                            <th></th>
                                            <td width="150px" class="text-start" scope="col">Jumlah</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($data->gaji_pokok > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Gaji pokok</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->gaji_pokok, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        <!-- Invoice item 2-->
                                        @if($data->tunj_um > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Tunj. Uang Makan</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->tunj_um, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        <!-- Invoice item 3-->
                                        @if($data->tunj_pengawas > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Tunj. Pengawas</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->tunj_pengawas, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_koefisien > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Tunj. Koefisien</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->tunj_koefisien, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_mk > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Tunj. Masa Kerja</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->tunj_mk, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        <!-- Invoice item 4-->
                                        @if($data->tunj_transport > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Tunj. Transport</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->tunj_transport, 0, ",", ".") ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        @if($data->tunj_lap)
                                        <tr>
                                            <td>Tunj. Lapangan</td>
                                            <td>:</td>
                                            <td>Rp{{ number_format($data->tunj_lap, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->ot > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Lembur</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->ot, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->hm > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Hour machine</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->hm) ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        @if($data->insentif > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Insentif</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->insentif, 0, ",", ".") ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        @if($data->rapel > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Rapel</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->rapel, 0, ",", ".") ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        @if($data->bonus > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Bonus</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->bonus, 0, ",", ".") ?? '-' }}</td>
                                        </tr>
                                        @endif
                                        @if($data->thr > 0)
                                        <tr class="">
                                            <td>
                                                <div class="">Tunj. hari raya</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->thr, 0, ",", ".") ?? '-' }}</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="column-bet">
                                <table class="table mb-0">
                                    <thead class="border-bottom">
                                        <tr class="small text-uppercase text-muted">
                                            <td width="100px" class="text-start" scope="col">Potongan</td>
                                            <th></th>
                                            <td width="140px" class="text-start" scope="col">Jumlah</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($data->jht > 0)
                                        <tr class="">
                                            <td class="">BPJS TK JHT</td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->jht, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        <!-- Invoice item 2-->
                                        @if($data->jp > 0)
                                        <tr class="">
                                            <td class="">BPJS TK JP</td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->jp, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        <!-- Invoice item 3-->
                                        @if($data->pot_bpjskes > 0)
                                        <tr class="">
                                            <td class="">BPSJ Kesehatan</td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->pot_bpjskes, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->unpaid_leave > 0)
                                        <tr class="">
                                            <td class="">Deduction Unpaid Leave</td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->unpaid_leave, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->deduction > 0)
                                        <tr class="">
                                            <td class="">Deduction</td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->deduction, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        @if($data->deduction_pph21 > 0)
                                        <tr class="">
                                            <td class="">Deduction PPH 21</td>
                                            <td width="20px">:</td>
                                            <td class="">Rp{{ number_format($data->deduction_pph21, 0, ",", ".") }}</td>
                                        </tr>
                                        @endif
                                        <tr class="mb-2">
                                            <td class="">Durasi SP</td>
                                            <td width="20px">:</td>
                                            <td class="">{{ $data->durasi_sp <= '2015-01-01' ? '-' : $data->durasi_sp}}</td>
                                        </tr>
                                        <tr class="">
                                            <td class="pb-0">
                                                <div class="text-uppercase small fw-200">
                                                    Total diterima
                                                </div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="pb-0">Rp{{ number_format($total_diterima, 0, ",",".") }}</td>
                                        </tr>
                                        <tr class="">
                                            <td class="pb-0">
                                                <div class="text-uppercase small fw-200">Total deduction</div>
                                            </td>
                                            <td width="20px">:</td>
                                            <td class="pb-0">Rp{{ number_format($total_deduction, 0, ",",".") }}</td>
                                        </tr>
                                        <tr>
                                            <td class="pb-0">
                                                <div class="text-uppercase small fw-200">Total penghasilan</div>
                                            </td>
                                            <td>:</td>
                                            <td class="pb-0">
                                                <div class="h6 mb-0 fw-700 text-green">Rp{{ number_format($data->tot_diterima, 0, ",", ".") }} </div>
                                            </td>
                                        </tr>
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
                                <div class="small">{{ $data->bank_number }}</div>
                                <div class="small">{{ $data->bank_name }}</div>
                            </div>
                            <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                                <!-- Invoice - sent from info-->
                                <div class="small text-muted text-uppercase fw-700 mb-2">Payroll Sistem : </div>
                                <div class="h6 mb-1">PT VDNI</div>
                                <div class="small">Payroll</div>
                                @if($data->tanggal_gajian == '')
                                <div class="small">Morosi, 31 {{ $nm_bln }} {{ $thn }}</div>
                                @else
                                <div class="small">Morosi, {{ tgl_indo($data->tanggal_gajian) }}</div>
                                @endif
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
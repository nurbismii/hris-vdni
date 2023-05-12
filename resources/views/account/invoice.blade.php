<x-app-layout title="Invoice">

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="credit-card"></i></div>
                            Detail Gaji
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-blue" href="{{ route('slipgaji', Auth::user()->employee_id) }}">
                            <i class="me-1" data-feather="printer"></i>
                            Print
                        </a>
                        <a class="btn btn-sm btn-light text-blue" href="/account/information">
                            <i class="me-1" data-feather="x"></i>
                            Tutup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <!-- Invoice-->
        <div class="card invoice">
            <div class="card-header p-4 p-md-5 border-bottom-0 bg-gradient-primary-to-secondary text-white-50">
                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-start">
                        <!-- Invoice branding-->
                        <img class="invoice-brand-img rounded-circle mb-4" src="{{ asset('assets/img/illustrations/profiles/profile-4.png') }}" alt="" />
                        <div class="h2 text-white mb-0">{{ Auth::user()->name }} </div>
                        {{ Auth::user()->employee_id}} <br />
                        {{ $data->departemen  }} <br />
                        {{ $data->divisi }} - {{ $data->posisi }} <br />
                    </div>
                    <div class="col-12 col-lg-auto text-center text-lg-end">
                        <!-- Invoice details-->
                        <div class="h3 text-white">Invoice</div>
                        #{{ strtoupper(substr($data->id, 0, 5)) }}
                        <br />
                        SLIP GAJI FEBRUARY
                        <br />
                        ( Periode {{ date('d F', strtotime($data->mulai_periode)) }} - {{ date('d F', strtotime($data->akhir_periode)) }} )
                    </div>
                </div>
            </div>
            <div class="card-body p-4 p-md-5">
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <!-- Invoice item 1-->
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Total Hari Kerja</div>
                                </td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ $data->jumlah_hari_kerja }}</td>
                                <td class="text-end fw-bold">Hari</td>
                            </tr>
                            <!-- Invoice item 2-->
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Status Gaji</div>
                                </td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold"></td>
                                <td class="text-end fw-bold">{{ ucfirst($data->status_gaji) }}</td>
                            </tr>
                            <!-- Invoice item 3-->
                            <tr class="border-bottom">
                                <td>
                                    <div class="fw-bold">Total Machine Hour</div>
                                </td>
                                <td class="text-end fw-bold">:</td>
                                <td class="text-end fw-bold">{{ $data->jumlah_hour_machine }}</td>
                                <td class="text-end fw-bold">Hour</td>
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
                                    <th scope="col">Detail Gaji</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Gaji</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->gaji_pokok, 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Uang Makan</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->tunjangan_umum, 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Tunj. Pengawas</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->tunjangan_pengawas) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Tunj. Masa Kerja</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->tunjangan_mk) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Lembur</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->overtime) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Hour Machine</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->jumlah_hour_machine) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Rapel</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->rapel) }}</td>
                                </tr>
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
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">BPJS TK JHT</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->jht, 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">BPJS TK JP</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->jp, 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">BPJS Kesehatan</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->bpjs_kesehatan) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Deduction Unpaid Leave</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->deduction) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">deduction PPH 21</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->deduction_pph21) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Total Penghasilan:</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700">Rp.{{ number_format($total_diterima, 0, ",",".") }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Total Deduction :</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700 text-red"> - Rp.{{ number_format($total_deduction, 0, ",",".") }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Gaji Bersih:</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700 text-green">Rp.{{ number_format($gaji_bersih, 0, ",", ".") }}</div>
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
                        <div class="small text-muted text-uppercase fw-700 mb-2">Transfer to :</div>
                        <div class="h6 mb-1">{{ Auth::user()->name }}</div>
                        <div class="small">PT. VDNI</div>
                        <div class="small">Puuruy, Kec. Bondoala, Kabupaten Konawe, Sulawesi Tenggara 93354</div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <!-- Invoice - sent from info-->
                        <div class="small text-muted text-uppercase fw-700 mb-2">Created By : </div>
                        <div class="h6 mb-1"> </div>
                        <div class="small">PT. VDNI</div>
                        <div class="small">Payroll</div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Invoice - additional notes-->
                        <div class="small text-muted text-uppercase fw-700 mb-2">Note</div>
                        <div class="small mb-0">{{ $data->note }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    @endpush

</x-app-layout>
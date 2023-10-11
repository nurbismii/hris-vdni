<x-app-layout title="Slip-Gaji">

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
                            Salary details
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-blue" href="/account/information">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back
                        </a>
                        <a class="btn btn-sm btn-light text-blue" href="{{ route('slipgaji', $data->id) }}" target="_blank">
                            <i class="me-1" data-feather="printer"></i>
                            Print
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
            <div class="card-body p-2 p-md-4">
                <div class="text-center lh-1 mb-2">
                    <h4 class="fw-bold">PT VDNI</h4> <br>
                    <img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 50px;" alt=""><br> <br>
                    <span class="fw-normal mb-2"> Payslip </span> <br> <br>
                    <span class="fw-normal"> Periode ({{ date('F Y', strtotime($data->mulai_periode)) }} - {{ date('F Y', strtotime($data->akhir_periode)) }})</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">Employee ID</th>
                                <td>{{ $data->employee_id }}</td>
                                <td>Payable/Working Days</td>
                                <td>{{ $data->jumlah_hari_kerja }}/{{ $gaji_karyawan->jumlah_hari_kerja }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Employee Name</th>
                                <td>{{ Auth::user()->employee->nama_karyawan }}</td>
                                <td>Status Gaji</td>
                                <td>{{ ucfirst($data->status_gaji) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Departement</th>
                                <td>{{ Auth::user()->employee->divisi->departemen->departemen }}</td>
                                <td>Divisi</td>
                                <td>{{ ucfirst(Auth::user()->employee->divisi->nama_divisi) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Position</th>
                                <td>{{ $data->posisi }}</td>
                                <td>Overtime</td>
                                <td>0</td>
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
                                    <th scope="col">Salary detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($data->gaji_pokok > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Salary</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->gaji_pokok, 0, ",", ".") }}</td>
                                </tr>
                                @endif
                                @if($data->tunjangan_umum > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Allowance meal</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->tunjangan_umum, 0, ",", ".") }}</td>
                                </tr>
                                @endif
                                @if($data->tunjangan_pengawas > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Allowwance supervisor</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->tunjangan_pengawas) }}</td>
                                </tr>
                                @endif
                                @if($data->tunjangan_mk > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Allowance service year</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->tunjangan_mk) }}</td>
                                </tr>
                                @endif
                                @if($data->overtime > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Overtime</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->overtime) }}</td>
                                </tr>
                                @endif
                                @if($data->jumlah_hour_machine > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Hour Machine</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->jumlah_hour_machine) }}</td>
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
                                @if($data->bpjs_kesehatan > 0)
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">BPJS Kesehatan</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data->bpjs_kesehatan) }}</td>
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
                                        <div class="text-uppercase small fw-700 text-muted">Total Income :</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700">Rp.{{ number_format($total_diterima, 0, ",",".") }}</div>
                                    </td>
                                </tr>
                                @endif
                                @if($total_deduction > 0)
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Total Deduction :</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700 text-red"> - Rp.{{ number_format($total_deduction, 0, ",",".") }}</div>
                                    </td>
                                </tr>
                                @endif
                                @if($gaji_bersih > 0)
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Net Salary :</div>
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
                        <div class="small text-muted text-uppercase fw-700 mb-2">Transfer to :</div>
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
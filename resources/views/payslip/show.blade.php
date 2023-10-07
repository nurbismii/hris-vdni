<x-app-layout title="PaySlip">

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
                            PaySlip
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <form action="{{ route('generate.slip', $data['employee']['nik']) }}" method="post">
                            @csrf
                            <button class="btn btn-sm btn-light text-blue" type="submit">
                                <i class="me-1" data-feather="upload-cloud"></i>
                                Generate payslip
                            </button>
                        </form>
                        <a class="btn btn-sm btn-light text-blue" href="/salary/employee">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back
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
                <div class="text-center lh-1 mb-3">
                    <h4 class="fw-bold">PT VDNI</h4> <br>
                    <img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 50px;" alt=""><br> <br>
                    <span class="fw-normal mb-2"> PaySlip </span> <br> <br>
                    <span class="fw-normal"> Period ({{ date('d F Y', strtotime($start)) }} - {{ date('d F Y', strtotime($end)) }})</span>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row">Employee ID</th>
                                <td>{{ $data['employee']['nik'] }}</td>
                                <td>Payable/Working days</td>
                                <td>{{count($absensis) }} / {{ $data['salary']['jumlah_hari_kerja'] }} </td>
                            </tr>
                            <tr>
                                <th scope="row">Employee Name</th>
                                <td>{{ $data['employee']['nama_karyawan'] }}</td>
                                <td>Salary status</td>
                                <td>{{ ucfirst($data['salary']['status_gaji']) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Departement</th>
                                <td>{{ Auth::user()->employee->divisi->departemen->departemen }}</td>
                                <td>Divisi</td>
                                <td>{{ ucfirst(Auth::user()->employee->divisi->nama_divisi) }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Position</th>
                                <td>{{ $data['employee']['posisi'] }}</td>
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
                                    <th scope="col">Salary Detail</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Salary</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['daily_salary'], 2, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Meal allowance</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['meal_allowance'], 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Supervisor allowance</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['salary']['tunj_pengawas']) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Service year allowance</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['salary']['tunj_masa_kerja']) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Overtime</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">0</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Hour Machine</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">0</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Rapel</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">0</td>
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
                                    <td class="text-end fw-bold">{{ number_format($data['jht'], 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">BPJS TK JP</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['jp'], 0, ",", ".") }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">BPJS Kesehatan</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['bpjs_kesehatan']) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Deduction Unpaid Leave</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['deduction_unpaid_leave']) }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td>
                                        <div class="fw-bold">Deduction PPH 21</div>
                                    </td>
                                    <td class="text-end fw-bold">:</td>
                                    <td class="text-end fw-bold">Rp.</td>
                                    <td class="text-end fw-bold">{{ number_format($data['deduction_pph21']) }}</td>
                                </tr>
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Total income :</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700">Rp.{{ number_format($data['total_diterima'], 0, ",",".") }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Total Deduction :</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700 text-red"> - Rp.{{ number_format($data['total_deduction'], 0, ",",".") }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-end pb-0" colspan="3">
                                        <div class="text-uppercase small fw-700 text-muted">Net salary :</div>
                                    </td>
                                    <td class="text-end pb-0">
                                        <div class="h5 mb-0 fw-700 text-green">Rp.{{ number_format($data['gaji_bersih'], 0, ",", ".") }}</div>
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
                        <div class="small">PT VDNI</div>
                        <div class="small">Puuruy, Kec. Bondoala, Kabupaten Konawe, Sulawesi Tenggara 93354</div>
                    </div>
                    <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
                        <!-- Invoice - sent from info-->
                        <div class="small text-muted text-uppercase fw-700 mb-2">Created By : </div>
                        <div class="h6 mb-1"> </div>
                        <div class="small">PT VDNI</div>
                        <div class="small">Payroll</div>
                    </div>
                    <div class="col-lg-6">
                        <!-- Invoice - additional notes-->
                        <div class="small text-muted text-uppercase fw-700 mb-2">Note</div>
                        <div class="small mb-0">Test Note</div>
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
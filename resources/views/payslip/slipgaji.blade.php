<x-app-layout title="PaySlip">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="calendar"></i></div>
                            PaySlip
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="col-xl-12">
            <div class="card mb-3">
                <form action="{{ url('salary/payslip') }}" method="get">
                    @csrf
                    <div class="card-body">
                        <div class="row gx-3">
                            <div class="col-md-1">
                                <label for="">Select period</label>
                            </div>
                            <div class="col-md-8 mb-2">
                                <input class="form-control" name="period" type="month" required />
                            </div>
                            <div class="d-grid col-md-3 mb-2">
                                <button class="btn btn-light text-primary" type="submit">
                                    <i class="me-1" data-feather="search"></i>
                                    Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow-x:auto;">
                    <table id="datatablesSimple" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Trx ID</th>
                                <th>Employee ID</th>
                                <th>Working days</th>
                                <th>Net salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr>
                                <td class="text-primary">
                                    <a class="text-primary" href="{{ route('payslip.print', $data->id) }}" target="_blank">#{{ strtoupper(substr($data->id, 0, 4)) }}</a>
                                </td>
                                <td>{{ $data->employee_id }}</td>
                                <td>{{ $data->jumlah_hari_kerja }}</td>
                                <td><b>Rp.{{ number_format($data->total_diterima) }}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <x-toastr />

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @endpush
</x-app-layout>
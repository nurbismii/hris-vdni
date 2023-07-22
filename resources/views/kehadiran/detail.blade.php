<x-app-layout title="Employee">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="calendar"></i></div>
                            Data Absensi
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-3">
        <nav class="nav nav-borders">
            <a class="nav-link {{ (request()->segment(2) == 'all-in') ? 'active' : '' }} ms-0" href="/absen/detail/all-in">Data Absensi</a>
            <a class="nav-link {{ (request()->segment(2) == 'detail') ? 'active' : '' }} ms-0" href="/absen/detail">Import Data Absensi</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-12">
                <x-message />
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('import.absensi') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <label class="form-label">Bulk absensi:</label>
                                <input class="form-control" type="file" name="file" id="formFile">
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('import.destroy.absensi') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <label class="form-label">Bulk hapus absensi :</label>
                                <input class="form-control" type="file" name="file" id="formFile">
                                <button type="submit" class="btn btn-danger btn-sm mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <form action="{{ route('import.keterangan') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <label class="form-label">Bulk keterangan absensi :</label>
                                <input class="form-control" type="file" name="file" id="formFile">
                                <button type="submit" class="btn btn-success btn-sm mt-2">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @endpush
</x-app-layout>
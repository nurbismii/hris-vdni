<x-app-layout title="Keterangan Absen">

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Keterangan Absen
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="overflow-x:auto;">
                        <h1 class="text-center text-white">{{ $bulan->nama_bulan }} {{ $bulan->periode_tahun->tahun }}</h1>
                    </div>
                </div>
            </div>
            <hr class="mt-0 mb-4" />
            <x-message />
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Foto Profil</div>
                    <div class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" alt="" />
                        <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 5MB</div>
                        <button class="btn btn-primary btn-sm" type="button">Unggah foto profil</button>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Data Karyawan </div>
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Name</label>
                                <input class="form-control" name="name" type="text" value="{{ $karyawan->nama_karyawan }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Email address</label>
                                <input class="form-control" name="email" type="email" value="{{ $karyawan->email }}" disabled />
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Departemen</label>
                                <input class="form-control" value="{{ $divisi->departemen->departemen }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Divisi</label>
                                <input class="form-control" value="{{ $divisi->nama_divisi }}" disabled />
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Jabatan</label>
                                <input class="form-control" value="{{ $karyawan->jabatan }}" disabled />
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Posisi</label>
                                <input class="form-control" value="{{ $karyawan->posisi }}" disabled />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body" style="overflow-x:auto;">
                        <table class="table accordion table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Total Alpa</th>
                                    <th>Paid Leave</th>
                                    <th>Unpaid Leave</th>
                                    <th>Total Sakit</th>
                                    <th>Total Off</th>
                                    <th>Total Cuti</th>
                                    <th>Total Libur</th>
                                    <th>Total Workdays</th>
                                    <th>Total Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr data-bs-toggle="collapse" data-bs-target="#accord1">
                                    <th scope="row"><i data-feather="corner-right-down"></i></th>
                                    <td>{{ $detail_absen->nik_karyawan }}</a></td>
                                    <td>{{ getName($detail_absen->nik_karyawan) }}</td>
                                    <td>{{ $detail_absen->total_alpa }}</td>
                                    <td>{{ $detail_absen->paid_leave }}</td>
                                    <td>{{ $detail_absen->unpaid_leave }}</td>
                                    <td>{{ $detail_absen->total_sakit }}</td>
                                    <td>{{ $detail_absen->total_off }}</td>
                                    <td>{{ $detail_absen->total_cuti }}</td>
                                    <td>{{ $detail_absen->total_libur }}</td>
                                    <td>{{ $detail_absen->total_workdays }}</td>
                                    <td>{{ $detail_absen->total_absen }}</td>
                                </tr>
                                <tr class="collapse accordion-collapse" id="accord1" data-bs-parent=".table">
                                    <td colspan="12">
                                        <table class="table table-condensed table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Mulai Izin</th>
                                                    <th>Tanggal Selesai Izin</th>
                                                    <th>Total Izin</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($keterangan_absen as $data)
                                                <tr>
                                                    <td>{{ date('d F Y', strtotime($data->tanggal_mulai_izin)) }}</a></td>
                                                    <td>{{ date('d F Y', strtotime($data->tanggal_selesai_izin)) }}</a></td>
                                                    <td>{{ $data->total_izin }}</td>
                                                    <td>{{ $data->keterangan_izin }}</td>
                                                    <td>{{ ucwords($data->status_izin) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    @endpush

</x-app-layout>
<x-app-layout title="Dashboard">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/datetime/1.4.0/css/dataTables.dateTime.min.css" rel="stylesheet" />
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endpush

    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="activity"></i></div>
                            {{ $data->title ?? 'Dashboard'}}
                        </h1>
                        <div class="page-header-subtitle fw-bold">{{ $data->subtitle ?? '' }}</div>
                        <div class="">{{ $data->description ?? '' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @if(strtolower($role) == 'administrator')
    <div class="container-xl px-4 mt-n10">
        <div class="row">
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Rekrutmen (Bulanan)</div>
                                <div class="text-lg fw-bold">{{ $total_pwkt1_perbulan }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="user-plus"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="/contract">Selengkapnya...</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-warning text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Karyawan</div>
                                <div class="text-lg fw-bold">{{ $total_karyawan }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="users"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="/employees">Selengkapnya...</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-success text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Divisi</div>
                                <div class="text-lg fw-bold">{{ $total_divisi }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="link"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="/departemen">Selengkapnya...</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-xl-3 mb-4">
                <div class="card bg-danger text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Pengguna</div>
                                <div class="text-lg fw-bold">{{ $total_pengguna }}</div>
                            </div>
                            <i class="feather-xl text-white-50" data-feather="user-check"></i>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-items-center justify-content-between small">
                        <a class="text-white stretched-link" href="users">Selengkapnya...</a>
                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-6 mb-4">
                <div class="card card-waves card-header-actions h-100">
                    <div class="card-header text-muted 75">
                        Karyawan Masuk
                    </div>
                    <div class="card-body">
                        <div class="chart-area mb-4 mb-lg-0" style="height: 20rem;"><canvas id="myAreaChart" width="100%" height="40%"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-4">
                <div class="card card-angles card-header-actions h-100">
                    <div class="card-header text-muted 75">
                        Karyawan Keluar
                    </div>
                    <div class="card-body">
                        <div class="chart-bar mb-4 mb-lg-0" style="height: 20rem;"><canvas id="barChart1" width="100%" height="0"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-8">
                <div class="card card-angles mb-3">
                    <div class="card-header text-muted 75">
                        Rentang Umur
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="dashboardNavContent">
                            <div class="tab-pane fade show active" id="rentang-umur" role="tabpanel" aria-labelledby="overview-pill">
                                <div class="chart-bar mb-4 mb-lg-0" style="height: 20rem"><canvas id="barChart" width="100%" height="0"></canvas></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-header-actions mb-4">
                    <div class="card-header text-muted 75">
                        Status Karyawan
                        @if($req_awal_prd && $req_akhir_prd)
                        <div>
                            {{ date('d F Y', strtotime($req_awal_prd)) }} - {{ date('d F Y', strtotime($req_akhir_prd)) }}
                        </div>
                        @endif
                        <a class="btn btn-sm btn-primary-soft text-primary" data-bs-toggle="modal" data-bs-target="#selectPeriode">Cari periode</a>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="dashboardNavContent">
                            <div class="tab-pane fade" id="rentang-umur" role="tabpanel" aria-labelledby="overview-pill">
                                <div class="chart-pie mb-4 mb-lg-0" style="height: 20rem"><canvas id="pieChart1" width="100%" height="0"></canvas></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12 mb-4">
                        <div class="card card-header-actions h-100">
                            <div class="card-header text-muted 75">
                                Presensi Terbaru
                            </div>
                            <div class="card-body">
                                <div class="timeline timeline-xs">
                                    @foreach($presensi_terakhir as $row)
                                    <div class="timeline-item">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">{{ $row->created_at->diffForHumans() }}</div>
                                            <div class="timeline-item-marker-indicator bg-green"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Presensi terbaru
                                            <a class="fw-bold text-dark" href="#!">{{ getName($row->nik_karyawan) }}</a>
                                            Berhasil melakukan presensi
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4">
                <div class="row">
                    <div class="col-xl-6 col-xxl-12">
                        <div class="card mb-4">
                            <div class="card-header text-muted 75">Status Kontrak</div>
                            <div class="card-body">
                                <div class="chart-pie mb-4 mb-lg-0" style="height: 20rem"><canvas id="pieChart" width="100%" height="0"></canvas></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-12">
                        <div class="card card-header-actions mb-4">
                            <div class="card-header text-muted 75">
                                {{ ucwords(strtolower(getNamaKabupaten($kabupaten->kabupaten_id))) ?? 'Tidak ditemukan'}}
                                <a class="btn btn-sm btn-primary-soft text-primary" data-bs-toggle="modal" data-bs-target="#selectDaerah">Pilih Lokasi</a>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">{{ $daerah[0]['kecamatan'] ?? 'Tidak tersedia'}}</div>
                                    <div class="small">{{ $daerah[0]['total'] ?? '0'}} Karyawan</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-danger-soft text-danger" role="progressbar" style="width: {{number_format($persen_daerah_1)}}%" aria-valuenow="{{number_format($persen_daerah_1)}}" aria-valuemin="0" aria-valuemax="100">{{ number_format($persen_daerah_1, 2) }}%</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">{{ $daerah[1]['kecamatan'] ?? 'Tidak tersedia' }}</div>
                                    <div class="small">{{ $daerah[1]['total'] ?? '0'}} Karyawan</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-warning-soft text-warning" role="progressbar" style="width: {{number_format($persen_daerah_2)}}%" aria-valuenow="{{number_format($persen_daerah_1)}}" aria-valuemin="0" aria-valuemax="100">{{ number_format($persen_daerah_2, 2) }}%</div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">{{ $daerah[2]['kecamatan'] ?? 'Tidak tersedia'}}</div>
                                    <div class="small">{{ $daerah[2]['total'] ?? '0'}} Karyawan</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-primary-soft text-primary" role="progressbar" style="width: {{number_format($persen_daerah_3)}}%" aria-valuenow="{{number_format($persen_daerah_1)}}" aria-valuemin="0" aria-valuemax="100">{{ number_format($persen_daerah_3, 2) }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-12">
                        <div class="card h-100">
                            <div class="card-header text-muted 75">Terakhir Aktif</div>
                            <div class="card-body">
                                @foreach($terakhir_login as $d)
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center flex-shrink-0 me-3">
                                        <div class="avatar avatar-xl me-3 bg-gray-200"><img class="avatar-img img-fluid" src="assets/img/illustrations/profiles/profile-1.png" alt="" /></div>
                                        <div class="d-flex flex-column fw-bold">
                                            <a class="text-dark line-height-normal mb-1" href="#!">{{ getName($d->nik_karyawan) ?? '' }}</a>
                                            <div class="small text-muted line-height-normal">{{ date('Y-m-d H:i:s', strtotime($d->terakhir_login)) }}</div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="modal fade" id="selectPeriode" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter periode</h5>
                    </h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('dashboard') }}" method="GET" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1">Mulai Periode</label>
                            <input type="date" name="mulai_periode" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Akhir Periode</label>
                            <input type="date" name="akhir_periode" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="selectDaerah" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih lokasi</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('dashboard') }}" method="GET" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1">Provinsi</label>
                            <select name="provinsi_id" class="form-select" id="provinsi_id">
                                <option value="" disabled selected>- Pilih Lokasi -</option>
                                @foreach($provinsi as $row)
                                <option value="{{ $row->id }}">{{ $row->provinsi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Kabupaten</label>
                            <select name="kabupaten" class="form-select" id="kabupaten_id"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        var rekrutmen_record = JSON.parse('{!! json_encode($chart_rekrut) !!}');
        var resign_record = JSON.parse('{!! json_encode($chart_resign) !!}');
        var chart_status_kontrak = JSON.parse('{!! json_encode($chart_status_kontrak) !!}');
        var chart_status_karyawan = JSON.parse('{!! json_encode($chart_status_karyawan) !!}');
        var umur_karyawan = JSON.parse('{!! json_encode($umur_karyawan) !!}');
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#table-karyawan-dashboard').DataTable({
                pageLength: 10,
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                ajax: {
                    url: "employees/server-side",
                    data: function(d) {
                        d.umur_mulai = $('#umur_mulai').val()
                        d.umur_akhir = $('#umur_akhir').val()
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'nama_karyawan'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin'
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir'
                    },
                    {
                        data: 'umur',
                        name: 'umur'
                    }
                ],
                order: [
                    [4, 'desc']
                ]
            });

            $('#provinsi_id').on('change', function() {
                var provinsiID = $(this).val();
                if (provinsiID) {
                    $.ajax({
                        url: 'dashboard/fetch-kabupaten/' + provinsiID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#kabupaten_id').empty();
                                $('#kabupaten_id').append('<option hidden>- Pilih Kabupaten -</option>');
                                $.each(data, function(id, kabupaten) {
                                    $('select[name="kabupaten"]').append('<option value="' + kabupaten.id + '">' + kabupaten.kabupaten + '</option>');
                                });
                            } else {
                                $('#kabupaten').empty();
                            }
                        }
                    });
                } else {
                    $('#kabupaten').empty();
                }
            });
        });
    </script>

    <x-toastr />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/demo/chart-area-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.0/js/dataTables.dateTime.min.js"></script>

    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js')}}"></script>
    <script src="{{ asset('assets/js/chart.js')}}"></script>

    @endpush
</x-app-layout>
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
        <x-message />
        <div class="row">
            <div class="col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header text-muted 75">
                        Karyawan Masuk
                    </div>
                    <div class="card-body">
                        <div class="chart-area"><canvas id="myAreaChart" width="100%" height="30"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 mb-4">
                <div class="card card-header-actions h-100">
                    <div class="card-header text-muted 75">
                        Karyawan Keluar
                    </div>
                    <div class="card-body">
                        <div class="chart-bar"><canvas id="barChart1" width="100%" height="38"></canvas></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-8">
                <!-- Tabbed dashboard card example-->
                <div class="card mb-3">
                    <div class="card-header border-bottom">
                        <!-- Dashboard card navigation-->
                        <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                            <li class="nav-item"><a class="nav-link" id="activities-pill" href="#karyawan" data-bs-toggle="tab" role="tab" aria-controls="activities" aria-selected="true">Karyawan</a></li>
                            <li class="nav-item me-1"><a class="nav-link" id="overview-pill" href="#rentang-umur" data-bs-toggle="tab" role="tab" aria-controls="overview" aria-selected="false">Rentang Umur</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="dashboardNavContent">
                            <!-- Dashboard Tab Pane 1-->
                            <div class="tab-pane fade" id="rentang-umur" role="tabpanel" aria-labelledby="overview-pill">
                                <div class="chart-area mb-4 mb-lg-0" style="height: 20rem"><canvas id="barChart" width="100%" height="0"></canvas></div>
                            </div>
                            <!-- Dashboard Tab Pane 2-->
                            <div class="tab-pane fade show active" id="karyawan" role="tabpanel" aria-labelledby="activities-pill">
                                <table class="table table-hover" id="table-karyawan-dashboard">
                                    <!-- <div class="row mb-3">
                                        <div class="mb-3 col-2 mt-2">
                                            <label class="small mb-1">Rentang Umur</label>
                                        </div>
                                        <div class="mb-3 col-3">
                                            <input type="number" name="umur_mulai" id="umur_mulai" placeholder="Awal" class="form-control">
                                        </div>
                                        <div class="mb-3 col-3">
                                            <input type="number" name="umur_akhir" id="umur_akhir" placeholder="Akhir" class="form-control">
                                        </div>
                                        <div class="mb-3 col-4">
                                            <select name="jenis_kelamin" class="form-select" id="jenis_kelamin">
                                                <option value="" disabled selected>- Pilih Jenis Kelamin -</option>
                                                <option value="L">Laki - Laki</option>
                                                <option value="P">Perempuan</option>
                                            </select>
                                        </div>
                                    </div> -->
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Umur</th>
                                        </tr>
                                    </thead>
                                    <tbody> </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-8 mb-4">
                        <!-- Dashboard activity timeline example-->
                        <div class="card card-header-actions h-100">
                            <div class="card-header text-muted 75">
                                Presensi Terbaru
                                <!-- <div class="dropdown no-caret">
                                    <button class="btn btn-transparent-dark btn-icon dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="text-gray-500" data-feather="more-vertical"></i></button>
                                    <div class="dropdown-menu dropdown-menu-end animated--fade-in-up" aria-labelledby="dropdownMenuButton">
                                        <h6 class="dropdown-header">Filter Activity:</h6>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-green-soft text-green my-1">Commerce</span></a>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-blue-soft text-blue my-1">Reporting</span></a>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-yellow-soft text-yellow my-1">Server</span></a>
                                        <a class="dropdown-item" href="#!"><span class="badge bg-purple-soft text-purple my-1">Users</span></a>
                                    </div>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <div class="timeline timeline-xs">
                                    <!-- Timeline Item 1-->
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
                    <div class="col-xl-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header text-muted 75">Terakhir Aktif</div>
                            <div class="card-body">
                                <!-- Item 1-->
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
            <div class="col-xxl-4">
                <div class="row">
                    <div class="col-xl-6 col-xxl-12">
                        <!-- Team members / people dashboard card example-->
                        <div class="card mb-4">
                            <div class="card-header text-muted 75">Status Karyawan</div>
                            <div class="card-body">
                                <div class="chart-pie mb-4">
                                    <canvas id="pieChart" width="100%" height="68"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xxl-12">
                        <!-- Project tracker card example-->
                        <div class="card card-header-actions mb-4">
                            <div class="card-header text-muted 75">
                                {{ ucwords(strtolower(getNamaKabupaten($kabupaten->kabupaten_id))) ?? 'Tidak ditemukan'}}
                                <a class="btn btn-sm btn-primary-soft text-primary" data-bs-toggle="modal" data-bs-target="#selectDaerah">Pilih Lokasi</a>
                            </div>
                            <div class="card-body">
                                <!-- Progress item 1-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">{{ $daerah[0]['kecamatan'] ?? 'Tidak tersedia'}}</div>
                                    <div class="small">{{ $daerah[0]['total'] ?? '0'}} Karyawan</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-danger-soft text-danger" role="progressbar" style="width: {{number_format($persen_daerah_1)}}%" aria-valuenow="{{number_format($persen_daerah_1)}}" aria-valuemin="0" aria-valuemax="100">{{ number_format($persen_daerah_1, 2) }}%</div>
                                </div>
                                <!-- Progress item 2-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">{{ $daerah[1]['kecamatan'] ?? 'Tidak tersedia' }}</div>
                                    <div class="small">{{ $daerah[1]['total'] ?? '0'}} Karyawan</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-warning-soft text-warning" role="progressbar" style="width: {{number_format($persen_daerah_2)}}%" aria-valuenow="{{number_format($persen_daerah_1)}}" aria-valuemin="0" aria-valuemax="100">{{ number_format($persen_daerah_2, 2) }}%</div>
                                </div>
                                <!-- Progress item 3-->
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
                        <!-- Project tracker card example-->
                        <div class="card card-header-actions mb-4">
                            <div class="card-header text-muted 75">
                                Respon Permintaan
                            </div>
                            <div class="card-body">
                                <!-- Progress item 1-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Berhasil</div>
                                    <div class="small">{{ number_format($audit_200) ?? '0'}}%</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar" role="progressbar" style="background-color: rgba(75, 192, 192, 0.5);  width: {{number_format($audit_200)}}%" aria-valuenow="{{number_format($audit_200)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!-- Progress item 2-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Internal Server Error</div>
                                    <div class="small">{{ number_format($audit_500) ?? '0'}}%</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-danger" role="progressbar" style="background-color: rgba(255, 99, 132, 0.5); width: {{number_format($audit_500)}}%" aria-valuenow="{{number_format($audit_500)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!-- Progress item 3-->
                                <div class="d-flex align-items-center justify-content-between small mb-1">
                                    <div class="fw-bold">Page Expired</div>
                                    <div class="small">{{ number_format($audit_419) ?? '0'}}%</div>
                                </div>
                                <div class="progress mb-3">
                                    <div class="progress-bar bg-primary" role="progressbar" style="background-color: rgba(54, 162, 235, 0.5); width: {{number_format($audit_419)}}%" aria-valuenow="{{number_format($audit_419)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

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
        var status_karyawan_record = JSON.parse('{!! json_encode($chart_status_karyawan) !!}');
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
                    [0, 'desc']
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
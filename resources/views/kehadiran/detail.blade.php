<x-app-layout title="Employee">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/datetime/1.4.0/css/dataTables.dateTime.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
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
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalAddAbsensi">
                            <i class="me-1" data-feather="calendar"></i>
                            Bulk Absen
                        </a>
                        <a class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#modalDestroyAbsensi">
                            <i class="me-1" data-feather="trash"></i>
                            Bulk Hapus Absen
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 mt-3">
        <nav class="nav nav-borders">
            <a class="nav-link {{ (request()->segment(2) == 'all-in') ? 'active' : '' }} ms-0" href="/absen/detail/all-in">Semua Data</a>
            <a class="nav-link {{ (request()->segment(2) == 'detail') ? 'active' : '' }} ms-0" href="/absen/detail">Data Perbulan</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-12 mb-3">
                <x-message />
                <div class="card">
                    <div class="col-lg">
                        <form action="{{ url('absen/detail') }}" method="GET" class="nav flex-column" id="stickyNav">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="small mb-1">Tahun</label>
                                        <select name="tahun_id" id="tahun" class="form-select">
                                            <option value="" disabled selected>- Pilih Tahun -</option>
                                            @foreach($datas as $row)
                                            <option value="{{ $row->id }}">Tahun {{ $row->tahun }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="small mb-1">Bulan</label>
                                        <select name="bulan_id" id="bulan" class="form-select"></select>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm" type="submit">Filter</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @if(count($data_absen) > 0)
            <div class="col-lg-12">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body" style="overflow-x:auto;">
                        <h1 class="text-center text-white">Absensi {{ $bulan->nama_bulan ?? '' }} {{ $bulan->periode_tahun->tahun ?? '' }}</h1>
                    </div>
                </div>
            </div>
            @else
            <div class="col-lg-12">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body" style="overflow-x:auto;">
                        <h1 class="text-center text-white">Periode tidak tersedia...</h1>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="datatablesSimple" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
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
                                @foreach($data_absen as $data)
                                <tr>
                                    <td><a target="_blank" href="{{ url('absen/detail', ['params1' => $data->nik_karyawan, 'params2' => $data->periode_bulan_id]) }}">{{ $data->nik_karyawan }}</a></td>
                                    <td>{{ getName($data->nik_karyawan) }}</td>
                                    <td>{{ $data->total_alpa }}</td>
                                    <td>{{ $data->paid_leave }}</td>
                                    <td>{{ $data->unpaid_leave }}</td>
                                    <td>{{ $data->total_sakit }}</td>
                                    <td>{{ $data->total_off }}</td>
                                    <td>{{ $data->total_cuti }}</td>
                                    <td>{{ $data->total_libur }}</td>
                                    <td>{{ $data->total_workdays }}</td>
                                    <td>{{ $data->total_absen }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddAbsensi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bulk Data Absensi</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.absensi') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih file :</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success btn-sm" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDeleteEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload delete employee data</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.deleteKaryawanRoster') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select a file</label>
                            <input class="form-control" name="file" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success btn-sm" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddKeterangan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bulk Data Keterangan</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.keterangan') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih file :</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success btn-sm" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDestroyAbsensi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bulk Hapus Data Absensi</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.destroy.absensi') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih file :</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success btn-sm" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#tahun').on('change', function() {
                var tahunID = $(this).val();
                if (tahunID) {
                    $.ajax({
                        url: 'dropdown-bulan/' + tahunID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#bulan').empty();
                                $('#bulan').append('<option hidden>- Pilih Bulan -</option>');
                                $.each(data, function(id, bulan) {
                                    $('select[name="bulan_id"]').append('<option value="' + bulan.id + '">' + bulan.nama_bulan + '</option>');
                                });
                            } else {
                                $('#bulan').empty();
                            }
                        }
                    });
                } else {
                    $('#bulan').empty();
                }
            });
        });
    </script>
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.0/js/dataTables.dateTime.min.js"></script>
    @endpush
</x-app-layout>
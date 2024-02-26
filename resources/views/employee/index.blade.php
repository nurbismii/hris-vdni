<x-app-layout title="Karyawan">
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
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <style>
        td {
            text-transform: uppercase
        }

        .dt-buttons {
            display: none;
        }

        .pull-left ul {
            list-style: none;
            margin: 0;
            padding-left: 0;
        }

        .pull-left a {
            text-decoration: none;
            color: #ffffff;
        }

        .pull-left li {
            color: #ffffff;
            background-color: #2f2f2f;
            border-color: #2f2f2f;
            display: block;
            float: left;
            position: relative;
            text-decoration: none;
            transition-duration: 0.5s;
            padding: 12px 30px;
            font-size: .75rem;
            font-weight: 400;
            line-height: 1.428571;
        }

        .pull-left li:hover {
            cursor: pointer;
        }

        .pull-left ul li ul {
            visibility: hidden;
            opacity: 0;
            min-width: 9.2rem;
            position: absolute;
            transition: all 0.5s ease;
            margin-top: 8px;
            left: 0;
            display: none;
        }

        .pull-left ul li:hover>ul,
        .pull-left ul li ul:hover {
            visibility: visible;
            opacity: 1;
            display: block;
        }

        .pull-left ul li ul li {
            clear: both;
            width: 100%;
            color: #ffffff;
        }

        .ul-dropdown {
            margin: 0.3125rem 1px !important;
            outline: 0;
        }

        .firstli {
            border-radius: 0.2rem;
        }

        .firstli .material-icons {
            position: relative;
            display: inline-block;
            top: 0;
            margin-top: -1.1em;
            margin-bottom: -1em;
            font-size: 0.8rem;
            vertical-align: middle;
            margin-right: 5px;
        }
    </style>
    @endpush
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Data karyawan
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a href="/employees/mutasi" class="btn btn-sm btn-light text-primary">
                            <i class="me-1" data-feather="plus"></i>
                            Mutasi
                        </a>
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalUpdateEmployee">
                            <i class="me-1" data-feather="edit-3"></i>
                            Bulk perbarui
                        </a>
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalDeleteEmployee">
                            <i class="me-1" data-feather="trash"></i>
                            Bulk hapus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <nav class="nav nav-borders">
            <a class="nav-link {{ (request()->segment(1) == 'employees') ? 'active' : '' }} ms-0" href="/employees">Karyawan</a>
            <a class="nav-link {{ (request()->segment(1) == 'information') ? 'active' : '' }} ms-0" href="/">Informasi</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-collapsable mb-3">
                    <a class="card-header" href="#collapseFilterKaryawan" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">Filter
                        <div class="card-collapsable-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </a>

                    <div class="card-header">
                        <div class="pull-right">
                            <div class="pull-left float-end">
                                <nav role="navigation">
                                    <ul class="ul-dropdown">
                                        <li class="firstli">
                                            <i class="material-icons">Export</i><a href="#">data tabel</a>
                                            <ul>
                                                <li><a href="#">Export CSV</a></li>
                                                <li><a href="#">Export Excel</a></li>
                                                <li><a href="#">Export PDF</a></li>
                                                <li><a href="#">Print</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <div class="collapse show" id="collapseFilterKaryawan">
                        <form action="{{ route('karyawan.index') }}" method="get">
                            @csrf
                            <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-3 mb-2">
                                        <label class="small mb-1">Area</label>
                                        <select class="form-select" id="area_kerja">
                                            <option value="">- Pilih area -</option>
                                            <option value="VDNI">PT VDNI</option>
                                            <option value="VDNIP">PT VDNIP</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="small mb-1">Departemen</label>
                                        <select class="form-select" id="departemen">
                                            <option value="">- Pilih departemen -</option>
                                            @foreach($depts as $d)
                                            <option value="{{ $d->id }}">{{ $d->departemen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="small mb-1">Divisi</label>
                                        <select class="form-select" name="divisi" id="divisi"></select>
                                    </div>

                                    <div class="col-md-3 mb-2">
                                        <label class="small mb-1">Kontrak</label>
                                        <select class="form-select" id="status_karyawan">
                                            <option value="">- Pilih status kontrak -</option>
                                            <option value="PKWTT 固定工">PKWTT 固定工</option>
                                            <option value="PKWT 合同工">PKWT 合同工</option>
                                            <option value="TRAINING">TRAINING</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="small mb-1">Jenis kelamin</label>
                                        <select class="form-select" id="jenis_kelamin">
                                            <option value="">- Pilih jenis kelamin -</option>
                                            <option value="L">Laki-laki</option>
                                            <option value="P">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <label class="small mb-1">Status keluar</label>
                                        <select class="form-select" id="status_resign">
                                            <option value="">- Pilih status keluar -</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Resign">Resign</option>
                                            <option value="Mutasi">Mutasi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label class="small mb-1">Pendidikan terakhir</label>
                                        <select class="form-select" id="pendidikan_terakhir">
                                            <option value="">- Pilih gelar -</option>
                                            <option value="S3">S3</option>
                                            <option value="S2">S2</option>
                                            <option value="S1">S1</option>
                                            <option value="D4">D4</option>
                                            <option value="D3">D3</option>
                                            <option value="D2">D2</option>
                                            <option value="D1">D1</option>
                                            <option value="SMA">SMA</option>
                                            <option value="SMK">SMK</option>
                                            <option value="SMP">SMP</option>
                                            <option value="SD">SD</option>
                                        </select>
                                    </div>
                                    <div class="form-group row">
                                        <label for="umur" class="col-sm-2 col-form-label">Range umur</label>
                                        <div class="col-sm-2 mb-2">
                                            <input type="number" class="form-control" id="awal_umur" name="awal_umur">
                                        </div>
                                        <div class="col-sm-2 mb-2">
                                            <input type="number" class="form-control" id="akhir_umur" name="akhir_umur">
                                        </div>
                                    </div>
                                </div>

                                <a class="btn btn-sm btn-light text-primary" href="/employees">
                                    <i class="me-1" data-feather="trash"></i>
                                    Hapus
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="data-table-karyawan" class="table table-hover text-sm" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Area</th>
                                    <th>Dept</th>
                                    <th>Div</th>
                                    <th>Posisi</th>
                                    <th>Kontrak</th>
                                    <th>Sex</th>
                                    <th>Pendidikan</th>
                                    <th>Umur</th>
                                    <th>Status keluar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal update employee maatwebsite -->
    <div class="modal fade" id="modalUpdateEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Perbarui data karyawan</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateImport.employee') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih file : </label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal update emplooye maatwebsite end -->

    <!-- Modal delete emplooye maatwebsite -->
    <div class="modal fade" id="modalDeleteEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus data karyawan</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroyImport.employee') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Pilih file :</label>
                            <input class="form-control" name="file" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success" type="submit">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal delete emplooye maatwebsite end -->
    @push('scripts')
    <x-toastr />
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


    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#data-table-karyawan').DataTable({
                pageLength: 15,
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                dom: "Blfrtip",
                buttons: [{
                        text: 'csv',
                        extend: 'csvHtml5',
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        }
                    },
                    {
                        text: 'excel',
                        extend: 'excelHtml5',
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        }
                    },
                    {
                        text: 'pdf',
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        }
                    },
                    {
                        text: 'print',
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible:not(.not-export-col)'
                        }
                    },
                ],
                ajax: {
                    url: "employees/server-side",
                    data: function(d) {
                        d.status_karyawan = $('#status_karyawan').val()
                        d.status_resign = $('#status_resign').val()
                        d.area_kerja = $('#area_kerja').val()
                        d.departemen = $('#departemen').val()
                        d.nama_divisi = $('#divisi').val()
                        d.jenis_kelamin = $('#jenis_kelamin').val()
                        d.pendidikan_terakhir = $('#pendidikan_terakhir').val()
                        d.awal_umur = $('#awal_umur').val()
                        d.akhir_umur = $('#akhir_umur').val()
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'nama_karyawan',
                    },
                    {
                        data: 'area_kerja',
                        name: 'area_kerja',
                    },
                    {
                        data: 'departemen',
                        name: 'departemen',
                    },
                    {
                        data: 'nama_divisi',
                        name: 'nama_divisi',
                    },
                    {
                        data: 'posisi',
                        name: 'posisi',
                    },
                    {
                        data: 'status_karyawan',
                        name: 'status_karyawan'
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        render: function(data, type, row) {
                            badge = '';
                            switch (data) {
                                case 'L':
                                    badge = '<span class="badge bg-primary">' + 'Laki-laki' + '</span>';
                                    break;
                                case 'P':
                                    badge = '<span class="badge bg-warning">' + 'Perempuan' + '</span>';
                                    break;
                            }
                            return badge;
                        }
                    },
                    {
                        data: 'pendidikan_terakhir',
                        name: 'pendidikan_terakhir',
                        render: function(data, type, row) {
                            badge = '';
                            if (data == null) {
                                badge = '-';
                            } else {
                                badge = data;
                            }
                            return badge;
                        }
                    },
                    {
                        data: 'umur',
                        name: 'umur',
                    },
                    {
                        data: 'status_resign',
                        name: 'status_resign',
                        render: function(data, type, row) {
                            badge = '';
                            switch (data) {
                                case 'Aktif':
                                    badge = '<span class="badge bg-success">' + data + '</span>';
                                    break;
                                case 'Resign':
                                    badge = '<span class="badge bg-red">' + data + '</span>';
                                    break;
                                case 'Mutasi':
                                    badge = '<span class="badge bg-warning">' + data + '</span>';
                                    break;
                                case 'PHK':
                                    badge = '<span class="badge bg-red">' + data + '</span>';
                                    break;
                                case 'BAIK':
                                    badge = '<span class="badge bg-primary">' + data + '</span>';
                                    break;
                                case 'PUTUS KONTRAK':
                                    badge = '<span class="badge bg-secondary">' + data + '</span>';
                                    break;
                                case 'PASAL (50)':
                                    badge = '<span class="badge bg-info">' + data + '</span>';
                                    break;
                                case 'PB RESIGN':
                                    badge = '<span class="badge bg-red">' + data + '</span>';
                                    break;
                            }
                            return badge;
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

            $('#status_karyawan').change(function() {
                table.draw();
            });

            $('#status_resign').change(function() {
                table.draw();
            });

            $('#area_kerja').change(function() {
                table.draw();
            });

            $('#departemen').change(function() {
                table.draw();
            });

            $('#divisi').change(function() {
                table.draw();
            });

            $('#jenis_kelamin').change(function() {
                table.draw();
            });

            $('#pendidikan_terakhir').change(function() {
                table.draw();
            });

            $('#awal_umur').keyup(function() {
                table.draw();
            });

            $('#akhir_umur').keyup(function() {
                table.draw();
            });

            $("ul li ul li").click(function() {
                var i = $(this).index() + 1
                var table = $('#data-table-karyawan').DataTable();
                if (i == 1) {
                    table.button('.buttons-csv').trigger();
                } else if (i == 2) {
                    table.button('.buttons-excel').trigger();
                } else if (i == 3) {
                    table.button('.buttons-pdf').trigger();
                } else if (i == 4) {
                    table.button('.buttons-print').trigger();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#departemen').on('change', function() {
                var deptID = $(this).val();
                if (deptID) {
                    $.ajax({
                        url: '/employees/divisi/' + deptID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#divisi').empty();
                                $('#divisi').append('<option hidden>- Pilih Divisi -</option>');
                                $.each(data, function(id, divisi) {
                                    $('select[name="divisi"]').append('<option value="' + divisi.id + '">' + divisi.nama_divisi + '</option>');
                                });
                            } else {
                                $('#divisi').empty();
                            }
                        }
                    });
                } else {
                    $('#divisi').empty();
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
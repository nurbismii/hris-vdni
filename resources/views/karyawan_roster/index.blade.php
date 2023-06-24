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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Data Karyawan Roster
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalAddRoster">
                            <i class="me-1" data-feather="calendar"></i>
                            Baru
                        </a>
                        <a class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#modalDeleteEmployee">
                            <i class="me-1" data-feather="trash"></i>
                            Hapus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-12 mb-1">
                <x-message />
                <button class="btn btn-success mb-2 btn-sm float-end" data-bs-toggle="modal" data-bs-target="#aktifkanPengingat">Aktifkan Pengingat</button>
            </div>
            <div class="col-lg-12 mb-2">
                <div class="card">
                    <div class="card-body" style="overflow-x: auto;">
                        <table id="datatables" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th>Awal Periode</th>
                                    <th>Akhir Periode</th>
                                    <th>Pengingat</th>
                                    <th>Periode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list_periode as $data)
                                @if($periode['awal_periode'] == $data->awal_periode)
                                <tr class="table-warning text-center">
                                    <td>{{ $data->awal_periode }}</td>
                                    <td>{{ $data->akhir_periode }}</td>
                                    @isset($pengingat['periode_id'])
                                    @if($pengingat['periode_id'] == $periode['id'])
                                    <td>&radic;</td>
                                    @endif
                                    @endisset
                                    <td></td>
                                </tr>
                                @endif
                                @if($periode['awal_periode'] != $data->awal_periode)
                                <tr>
                                    <td>{{ $data->awal_periode }}</td>
                                    <td>{{ $data->akhir_periode }}</td>
                                    <td></td>
                                    <td>
                                        <form action="{{ url('roster') }}" method="GET" class="nav flex-column" id="stickyNav">
                                            @csrf
                                            <input name="awal_periode" id="date_awal" class="form-control" type="hidden" value="{{ $data->awal_periode }}" required>
                                            <input name="akhir_periode" id="date_awal" class="form-control" type="hidden" value="{{ $data->akhir_periode }}" required>
                                            <button class="btn btn-primary btn-sm" type="submit">Lihat</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="datatablesSimple" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>I</th>
                                    <th>II</th>
                                    <th>III</th>
                                    <th>IV</th>
                                    <th>V</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rosters as $data)
                                <tr>
                                    <td>{{ $data->nik_karyawan }}</td>
                                    <td>{{ getName($data->nik_karyawan) }}</td>
                                    <td>{{ date('d F Y', strtotime($data->minggu_pertama)) }}</td>
                                    <td>{{ date('d F Y', strtotime($data->minggu_kedua)) }}</td>
                                    <td>{{ date('d F Y', strtotime($data->minggu_ketiga)) }}</td>
                                    <td>{{ date('d F Y', strtotime($data->minggu_keempat)) }}</td>
                                    <td>{{ date('d F Y', strtotime($data->minggu_kelima)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="aktifkanPengingat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengingat</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pengingat') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3 col-lg">
                                <label class="small mb-1">Periode</label>
                                <select name="periode" class="form-control">
                                    <option disabled selected>Pilih Periode : </option>
                                    @foreach($list_periode as $row)
                                    <option value="{{$row->id}}">{{ $row->awal_periode }} - {{ $row->akhir_periode }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddRoster" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bulk Karyawan Roster</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('import.karyawanRoster') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
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

    @push('scripts')
    <script>
        $("#date_awal").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true //to close picker once year is selected
        });

        $("#date_akhir").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true //to close picker once year is selected
        });

        $("#date-pick-awal").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true //to close picker once year is selected
        });

        $("#date-pick-akhir").datepicker({
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            autoclose: true //to close picker once year is selected
        });

        const dataPeriode = document.getElementById('dataPeriode');
        if (dataCuti) {
            new simpleDatatables.DataTable(dataPeriode);
        }
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
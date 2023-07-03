<x-app-layout title="Setting Periode">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Data Periode Roster
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-12 mb-3">
                <x-message />
                <div class="card">
                    <div class="col-lg">
                        <form action="{{ route('store.periodeRoster') }}" method="POST" class="nav flex-column" id="stickyNav">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="mb-3 col-6">
                                        <label class="small mb-1">Awal Periode</label>
                                        <input name="awal_periode" id="date_awal" class="form-control" type="text" required>
                                    </div>
                                    <div class="mb-3 col-6">
                                        <label class="small mb-1">Akhir Periode</label>
                                        <input type="text" name="akhir_periode" id="date_akhir" min="2015" class="form-control" required>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm" type="submit">Tambah Periode</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x: auto;">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mulai Periode</th>
                                    <th>Akhir Periode</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->awal_periode }}</td>
                                    <td>{{ $data->akhir_periode }}</td>
                                    <td>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editPeriode{{$data->id}}"><i data-feather="edit"></i></a>
                                        <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#delPeriode{{$data->id}}"><i data-feather="trash-2"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @foreach($datas as $data)
    <div class="modal fade" id="editPeriode{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Perbarui Periode</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.periodeRoster', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    @csrf
                    {{ method_field('patch') }}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="small mb-1">Awal Periode</label>
                            <input type="text" name="awal_periode" class="date-own form-control" value="{{ $data->awal_periode }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Akhir Periode</label>
                            <input type="text" name="akhir_periode" class="date-own form-control" value="{{ $data->akhir_periode }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Kembali</button>
                        <button class="btn btn-primary btn-sm" type="submit">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($datas as $data)
    <div class="modal fade" id="delPeriode{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Periode</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroy.periodeRoster', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        Apa kamu yakin ingin menghapus data ini ({{ $data->awal_periode }}-{{$data->akhir_periode}})?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Kembali</button>
                        <button class="btn btn-primary btn-sm" type="submit">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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
    </script>
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
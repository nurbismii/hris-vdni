<x-app-layout title="Departemen">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="codepen"></i></div>
                            Data Departemen
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('export.div') }}">
                            <i class="me-1" data-feather="printer"></i>
                            Export
                        </a>
                        <a class="btn btn-sm btn-light text-primary" onclick="history.back()">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Kembali
                        </a>
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addDept">
                            <i class="me-1" data-feather="plus"></i>
                            Departemen
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </header>

    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="card bg-gradient-primary-to-secondary mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="me-3">
                        <div class="small text-white-50">Perusahaan :</div>
                        <div class="h1 text-white">{{ $data_pt->nama_perusahaan }}</div>
                    </div>
                    <div class="text-white">{{ count($data) }} Departemen</div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body" style="overflow-x: auto;">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Departemen</th>
                            <th>Kepala Dept</th>
                            <th>No Telpon</th>
                            <th>Grup</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td><a href="{{ url('departemen/' . $row->id . '/divisi')}}">{{ $row->departemen }}</a></td>
                            <td>{{ $row->kepala_dept }}</td>
                            <td>{{ $row->no_telp_departemen }}</td>
                            <td>{{ $row->status_pengeluaran }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editDept{{$row->id}}"><i data-feather="edit"></i></a>
                                <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteDept{{$row->id}}"><i data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Departemen</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('departemen.store') }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1">Departemen</label>
                            <input type="text" class="form-control" name="departemen">
                            <input type="hidden" class="form-control" name="perusahaan_id" value="{{ $data_pt->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Kepala Departemen</label>
                            <input type="text" class="form-control" name="kepala_dept">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">No Telpon</label>
                            <input type="text" class="form-control" name="no_telp_departemen">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Status Pengeluaran</label>
                            <input type="text" class="form-control" name="status_pengeluaran">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($data as $row)
    <div class="modal fade" id="editDept{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Departemen</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('departemen.update', $row->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('patch') }}
                        <div class="mb-3">
                            <label class="small mb-1">Departemen</label>
                            <input type="text" class="form-control" name="departemen" value="{{ $row->departemen }}">
                            <input type="hidden" class="form-control" name="perusahaan_id" value="{{ $data_pt->id }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Kepala Departemen</label>
                            <input type="text" class="form-control" name="kepala_dept" value="{{ $row->kepala_dept }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">No Telpon</label>
                            <input type="text" class="form-control" name="no_telp_departemen" value="{{ $row->no_telp_departemen }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Status Pengeluaran</label>
                            <input type="text" class="form-control" name="status_pengeluaran" value="{{ $row->status_pengeluaran }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Simpan perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($data as $row)
    <div class="modal fade" id="deleteDept{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Departemen</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('departemen.destroy', $row->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        <div class="center">
                            Yakin ingin menghapus data depertemen ini ({{ $row->departemen }}) ?
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @push('scripts')
    <x-toastr />

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
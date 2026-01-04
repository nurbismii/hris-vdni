<x-app-layout title="Departemen | Divisi">
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
                            <div class="page-header-icon"><i data-feather="globe"></i></div>
                            Detail Departemen
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('export.div') }}">
                            <i class="me-1" data-feather="printer"></i>
                            Export Divisi
                        </a>
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addDiv">
                            <i class="me-1" data-feather="plus"></i>
                            Tambah Divisi
                        </a>
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#perbaruiDiv">
                            <i class="me-1" data-feather="edit-3"></i>
                            Perbarui Divisi
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
                        <div class="small text-white-50">DEPARTEMEN 部门 :</div>
                        <div class="h1 text-white">{{ $data->departemen }}</div>
                    </div>
                    <div class="text-white">{{ count($divisi) }} Divisi</div>
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="small text-muted mb-2">Penanggung Jawab : </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg"><img class="avatar-img img-fluid" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" /></div>
                            <div class="ms-3">
                                <div class="fs-4 text-dark fw-500">Tiger Nixon</div>
                                <div class="small text-muted">Admin</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-lg"><img class="avatar-img img-fluid" src="{{ asset('assets/img/illustrations/profiles/profile-2.png')}}" /></div>
                            <div class="ms-3">
                                <div class="fs-4 text-dark fw-500">Garrett Winters</div>
                                <div class="small text-muted">Admin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="small text-muted mb-2">Data Divisi Departemen : </div>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Divisi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($divisi as $row)
                        <tr>
                            <th>{{ ++$no }}</th>
                            <td>{{ $row->nama_divisi }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editDiv{{$row->id}}"><i data-feather="edit"></i></a>
                                <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteDiv{{$row->id}}"><i data-feather="trash-2"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Divisi</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('divisi.store') }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="after-add-more">
                            <div class="row gx-3 mb-3">
                                <div class="col-md-12">
                                    <label class="small mb-1">Divisi</label>
                                    <input type="text" class="form-control" name="divisi[]">
                                    <input type="hidden" name="departemen_id" value="{{ $data->id }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="small"></label>
                                    <button type="button" class="btn btn-sm btn-success add-more">
                                        <i class="me-1" data-feather="plus"></i>Tambah
                                    </button>
                                </div>
                            </div>
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

    <div class="copy invisible">
        <div class="hide-me">
            <div class="row gx-3 mb-3">
                <div class="col-md-12">
                    <label class="small mb-1">Divisi</label>
                    <input type="text" class="form-control" name="divisi[]">
                    <input type="hidden" name="departemen_id" value="{{ $data->id }}">
                </div>
                <div class="col-md-2">
                    <label class="small"></label>
                    <button type="button" class="btn btn-sm btn-danger remove">
                        <i class="me-1" data-feather="trash"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete user -->
    @foreach($divisi as $data)
    <div class="modal fade" id="deleteDiv{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Penghapusan</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('divisi.destroy', $data->id) }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        Yakin ingin menghapus divisi ini ({{ $data->nama_divisi }})?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                        <button class="btn btn-primary" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal edit divisi -->
    @foreach($divisi as $data)
    <div class="modal fade" id="editDiv{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Divisi</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('divisi.update', $data->id) }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    @csrf
                    {{ method_field('patch') }}
                    <div class="modal-body">
                        <div class="row gx-3 mb-3">
                            <div class="col-md-12">
                                <label class="small mb-1">Divisi</label>
                                <input type="text" class="form-control" name="divisi" value="{{ $data->nama_divisi }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                        <button class="btn btn-primary" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Modal edit divisi -->

    <!-- Modal perbarui divisi -->
    @foreach($divisi as $data)
    <div class="modal fade" id="perbaruiDiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pilih departemen</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateDivisi') }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    @csrf
                    <div class="modal-body">
                        <div class="row gx-3 mb-3">
                            <div class="col-md-12 mb-3">
                                <label class="small mb-1">Departemen</label>
                                <input type="text" name="" value="{{ $data->departemen->departemen }}" class="form-control" readonly>
                                <input type="hidden" name="dept_id" value="{{ $data->departemen->id }}" class="form-control" readonly>
                            </div>
                            <div class="col-md-12">
                                <label class="small mb-1">Divisi yang ditambahkan</label>
                                <select name="div_id" class="form-select">
                                    <option value="">Pilih Divisi</option>
                                    @foreach($list_div as $ld)
                                    <option value="{{ $ld->id }}">{{ $ld->nama_divisi}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">No</button>
                        <button class="btn btn-primary" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Modal edit divisi -->

    @push('scripts')
    <x-toastr />

    <script type="text/javascript">
        $(document).ready(function() {
            $(".add-more").click(function() {
                var html = $(".copy").html();
                $(".after-add-more").after(html);
            });

            $("body").on("click", ".remove", function() {
                $(this).parents(".hide-me").remove();
            });
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
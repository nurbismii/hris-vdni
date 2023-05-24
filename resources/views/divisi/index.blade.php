<x-app-layout title="Users">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addDiv">
                            <i class="me-1" data-feather="plus"></i>
                            Tambah Divisi
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
                        <div class="small text-white-50">Nama Departemen :</div>
                        <div class="h1 text-white">{{ $data->departemen }}</div>
                    </div>
                    <div class="text-white">20 Divisi</div>
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body">
                <div class="small text-muted mb-2">Pengelola/Admin Departemen : </div>
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
                            <th>Divisi</th>
                            <th>Jabatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDiv" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Departemen</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('departemen.store') }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="after-add-more">
                            <div class="row gx-3 mb-3">
                                <div class="col-md-4">
                                    <label class="small mb-1">Divisi</label>
                                    <input type="text" class="form-control" name="departemen[]">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1">Jabatan</label>
                                    <input type="text" class="form-control" name="status_pengeluaran[]">
                                </div>
                                <div class="col-md-2 mt-3">
                                    <label class="small mt-5"></label>
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
                <div class="col-md-4">
                    <label class="small mb-1">Divisi</label>
                    <input type="text" class="form-control" name="departemen[]">
                </div>
                <div class="col-md-6">
                    <label class="small mb-1">Jabatan</label>
                    <input type="text" class="form-control" name="status_pengeluaran[]">
                </div>
                <div class="col-md-2 mt-3">
                    <label class="small mt-5"></label>
                    <button type="button" class="btn btn-sm btn-danger remove">
                        <i class="me-1" data-feather="trash"></i>Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
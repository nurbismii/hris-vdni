<x-app-layout title="PKWT">
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
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            PKWT 2 Month list
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalContract">
                            <i class="me-1" data-feather="user-plus"></i>
                            Kontrak Baru
                        </a>
                        <a class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalUpdateEmployee">
                            <i class="me-1" data-feather="edit-3"></i>
                            Update Kontrak
                        </a>
                        <a class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#modalDeleteEmployee">
                            <i class="me-1" data-feather="trash"></i>
                            Hapus Kontrak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <x-message />
        <!-- <div class="col-xl-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row gx-3 mb-3">
                        <div class="col-md-6">
                            <label class="small mb-1">Entry Date Start</label>
                            <input class="form-control" id="min" name="min" type="text" />
                        </div>
                        <div class="col-md-6">
                            <label class="small mb-1">Entry Date End</label>
                            <input class="form-control" id="max" name="max" type="text" />
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        <div class="card">
            <div class="card-body" style="overflow-x:auto;">
                <table id="data-contract" class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>No PKWT</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>No KTP</th>
                            <th>Posisi</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal showw employee -->
    <div class="modal fade" id="showContract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Contract</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">No PKWT</label>
                            <input class="form-control" type="text" name="no_pkwt" id="no_pkwt" value="no_pkwt">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm d-grid" type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal show emplooye end -->

    <!-- Modal update employee maatwebsite -->
    <div class="modal fade" id="modalContract" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload PKWT Step 1</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('contract/import-pkwt') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select a file</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success btn-sm" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal update emplooye maatwebsite end -->

    <!-- Modal update employee maatwebsite -->
    <div class="modal fade" id="modalUpdateEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update employee data</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select a file</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success btn-sm" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal update emplooye maatwebsite end -->

    <!-- Modal delete Contract maatwebsite -->
    <div class="modal fade" id="modalDeleteEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete employee data</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroyImport.contract') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select a file</label>
                            <input class="form-control" name="file" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success btn-sm" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal delete contract maatwebsite end -->

    @push('scripts')
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

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#data-contract').DataTable({
                pageLength: 25,
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                ajax: "/contract/server-side",
                columns: [{
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                    {
                        data: 'no_pkwt',
                        name: 'no_pkwt'
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'no_ktp',
                        name: 'no_ktp'
                    },
                    {
                        data: 'jabatan',
                        name: 'jabatan'
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });
        });

        $('body').on('click', '.showContract', function() {
            event.preventDefault();

            var me = $(this),
                url = me.attr('href'),
                title = me.attr('title');

            $('#modal-title').text(title);

            $.ajax({
                url: url,
                dataType: 'html',
                success: function(response) {
                    $('modal-body').html(response)
                }
            });

            $('modal').modal('show');
        });
    </script>
    @endpush
</x-app-layout>
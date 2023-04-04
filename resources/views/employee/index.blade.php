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
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Employee List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/employees/create">
                            <i class="me-1" data-feather="user-plus"></i>
                            Add New Employee
                        </a>
                        <a class="btn btn-sm btn-warning text-white" data-bs-toggle="modal" data-bs-target="#modalUpdateEmployee">
                            <i class="me-1" data-feather="edit-3"></i>
                            Update Employee
                        </a>
                        <a class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#modalDeleteEmployee">
                            <i class="me-1" data-feather="trash"></i>
                            Delete Employee
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <x-message />
        <div class="col-xl-12">
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
        </div>
        <div class="card">
            <div class="card-body" style="overflow-x:auto;">
                <table id="data-employee" class="table table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>BPJS Kesehatan</th>
                            <th>BPJS TK</th>
                            <th>Company</th>
                            <th>Join Date</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal update employee maatwebsite -->
    <div class="modal fade" id="modalUpdateEmployee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload employee data change</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('updateImport.employee') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select a file</label>
                            <input class="form-control" type="file" name="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Send</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Upload delete employee data</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroyImport.employee') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select a file</label>
                            <input class="form-control" name="file" type="file" id="formFile">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal delete emplooye maatwebsite end -->

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
        var minDate, maxDate;
        
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var min = minDate.val();
                var max = maxDate.val();
                var date = new Date(data[5]);

                if (
                    (min === null && max === null) ||
                    (min === null && date <= max) ||
                    (min <= date && max === null) ||
                    (min <= date && date <= max)
                ) {
                    return true;
                }
                return false;
            }
        );

        $(function() {

            minDate = new DateTime($('#min'), {
                format: 'MMMM Do YYYY'
            });
            maxDate = new DateTime($('#max'), {
                format: 'MMMM Do YYYY'
            });

            var table = $('#data-employee').DataTable({

                processing: true,
                serverSide: true,
                searching: true,
                ajax: "/employees/server-side",
                columns: [{
                        data: 'nik',
                        name: 'nik'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'bpjs_ket',
                        name: 'bpjs_ket',
                    },
                    {
                        data: 'bpjs_tk',
                        name: 'bpjs_tk',
                    },
                    {
                        data: 'company_name',
                        name: 'company_name'
                    },
                    {
                        data: 'entry_date',
                        name: 'entry_date'
                    }
                ]
            });

            $('#min, #max').on('change', function() {
                table.draw();
            });
        });
    </script>
    @endpush
</x-app-layout>
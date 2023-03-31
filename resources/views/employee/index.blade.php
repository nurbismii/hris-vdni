<x-app-layout title="Employee">
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
                            <i class="me-1" data-feather="user-plus"></i>
                            Update Employee
                        </a>
                        <a class="btn btn-sm btn-danger text-white" data-bs-toggle="modal" data-bs-target="#modalDeleteEmployee">
                            <i class="me-1" data-feather="user-plus"></i>
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
        <form action="{{ url('employees/filter') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-xl-5">
                    <div class="card mb-3" style="padding: 0.12rem !important;">
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <label class="small mb-1">NIK</label>
                                <input class="form-control" name="nik" type="text" placeholder="Search employee by NIK" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1">Entry Date Start</label>
                                    <input class="form-control" name="entry_date_start" type="date" />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1">Entry Date End</label>
                                    <input class="form-control" name="entry_date_end" type="date" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="text-center d-grid">
                                <button class="btn btn-primary btn-sm btn-block mb-1" type="submit">Filter</button>
                                <a class="btn btn-warning btn-sm btn-block" href="/employees">Clear filter</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card">
            <div class="card-body" style="overflow-x:auto;">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>NIK</th>
                            <th>Company</th>
                            <th>Join Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($datas)
                        @foreach($datas as $row)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar me-2"><img class="avatar-img img-fluid" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" /></div>
                                    {{ $row->name }} <br>
                                    @if($row->bpjs_ket)
                                    BPJS Kesehatan : {{ $row->bpjs_ket }} <br>
                                    @endif
                                    @if($row->bpjs_tk)
                                    BPJS TK : {{ $row->bpjs_tk }} <br>
                                    @endif
                                    @if($row->vaccine)
                                    Vaccine : {{ $row->vaccine == 3 ? 'Booster' : ($row->vaccine == 2 ? 'Vaccine 2' : ($row->vaccine == 1 ? 'Vaccine 1' : 'Not Vaccine')) }} <br>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $row->nik }}</td>
                            <td>{{ $row->company_name }}</td>
                            <td>{{ $row->entry_date }}</td>
                            <td>
                                <form action="" method="POST">
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editEmployee{{$row->nik}}"><i data-feather="edit"></i></a>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteEmployee{{$row->nik}}"><i data-feather="trash-2"></i></a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if($datas)
    @foreach($datas as $row)
    <div class="modal fade" id="editEmployee{{$row->nik}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload employee data change</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.employee',  $row->nik) }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('patch') }}
                        <div class="mb-3">
                            <label class="small mb-1">Name</label>
                            <input class="form-control" name="permission_role" type="text" placeholder="Enter role" required />
                            @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Description</label>
                            <textarea class="form-control" name="description" cols="30" rows="10"></textarea>
                            @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Status</label>
                            <select class="form-select" name="status" aria-label="Default select example" required>
                                <option selected disabled>Select a role:</option>
                                <option value="1">Active</option>
                                <option value="0">Not Active</option>
                            </select>
                            @error('status')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
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
    @endforeach
    @endif
    @if($datas)
    @foreach($datas as $row)
    <div class="modal fade" id="editEmployee{$row->nik}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload employee data change</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.employee',  $row->nik) }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('patch') }}

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-success" type="submit">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    @endif
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
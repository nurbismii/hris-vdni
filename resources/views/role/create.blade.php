<x-app-layout title="Create Role">
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
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Add Role
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/roles">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Role List
                        </a>
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#newRoleModal">
                            <i class="me-1" data-feather="user-plus"></i>
                            Add New Role
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-12">
                <x-message />
            </div>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body" style="overflow-x: auto;">
                        <table id="datatablesSimple" class="table">
                            <thead>
                                <tr>
                                    <th>Posisi</th>
                                    <th>Deksripsi</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                <tr>
                                    <td>{{ $data->permission_role }}</td>
                                    <td>{{ $data->description}}</td>
                                    <td>{{ ($data->status == '1') ? 'Aktif' : 'Tidak aktif'}}</td>
                                    <td>{{ date('d F Y', strtotime($data->created_at)) }}</td>
                                    <td>
                                        <a class="btn btn-purple btn-sm lift lift-sm" data-bs-toggle="modal" data-bs-target="#modalAccess" href="#!">Akses</a>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editRole{{$data->id}}"><i data-feather="edit"></i></a>
                                        <a class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteRole{{$data->id}}"><i data-feather="trash-2"></i></a>
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

    <div class="modal fade" id="modalAccess" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pilih akses</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" name="pengguna" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Pengguna</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" name="data_pengguna" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckChecked">Data Pengguna</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" name="riwayat_login" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckChecked">Riwayat Login</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Karyawan</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data Karyawan</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Akses Karyawan</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Import Karyawan</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Departemen</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Hubungan Industrial</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data PKWT 1</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Slip Gaji</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data Slip Gaji</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Import Slip Gaji</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Riwayat Import</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Kompensasi & Keuntungan</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data Roster</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data Pengajuan Cuti</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data Pengingat Cuti</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Data Absensi</label>
                            </div>
                        </div>
                        <hr>
                        <div class="col-4">
                            <div class="form-check mb-2">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="">
                                <label class="form-check-label" for="flexCheckDefault">Pengaturan</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Judul Dashboard</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Lokasi Presensi</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Periode Roster</label>
                            </div>
                            <div class="form-check mx-4 mb-2">
                                <input class="form-check-input" id="flexCheckChecked" type="checkbox" value="" checked">
                                <label class="form-check-label" for="flexCheckChecked">Waktu Kerja</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"><button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button></div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="newRoleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Role</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store.role') }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1">Role</label>
                            <input class="form-control" name="permission_role" type="text" placeholder="Enter role" required />
                            @error('permission_role')
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
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @foreach($datas as $data)
    <div class="modal fade" id="deleteRole{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Posisi baru</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroy.role', $data->id) }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        Apa kamu yakin ingin menghapus data ini_restore ({{ $data->permission_role }})?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Modal -->
    @foreach($datas as $data)
    <div class="modal fade" id="editRole{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.role', $data->id) }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('patch') }}
                        <div class="mb-3">
                            <label class="small mb-1">Role</label>
                            <input class="form-control" name="permission_role" type="text" value="{{$data->permission_role}}" />
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Description</label>
                            <textarea class="form-control" name="description" cols="30" rows="10">{{ $data->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Status</label>
                            <select class="form-select" name="status" aria-label="Default select example">
                                <option value="{{ $data->status }}">{{ $data->status == '1' ? 'Active' : 'Not Active' }}</option>
                                @if($data->status == 0)
                                <option value="1">Active</option>
                                @else
                                <option value="0">Not Active</option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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
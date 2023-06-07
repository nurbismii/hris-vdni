<x-app-layout title="Setting Dashboad">
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
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Data Waktu Absen
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addWaktuAbsen">
                            <i class="me-1" data-feather="plus"></i>
                            Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <x-message />
        <div class="card">
            <div class="card-body" style="overflow-x: auto;">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Shift</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Tipe</th>
                            <th>Keterangan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr>
                            <td>{{ $data->nama_shift }}</td>
                            <td>{{ date('H:i:s', strtotime($data->jam_masuk)) }}</td>
                            <td>{{ date('H:i:s', strtotime($data->jam_keluar)) }}</td>
                            @if($data->tipe == '1')
                            <td>Translator</td>
                            @elseif($data->tipe == ' 2')
                            <td>Karyawan</td>
                            @else
                            <td>Karyawan Shift</td>
                            @endif
                            <td>{{ $data->keterangan }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editWaktuAbsen{{$data->id}}"><i data-feather="edit"></i></a>
                                <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#delWaktuAbsen{{$data->id}}"><i data-feather="trash-2"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addWaktuAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Content</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store.waktu_absen') }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1">Shift</label>
                            <select name="nama_shift" class="form-select" required>
                                <option value="" disabled selected>- Pilih Shift -</option>
                                <option value="Pagi">Pagi</option>
                                <option value="Sore">Sore</option>
                                <option value="Malam">Malam</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Jam Masuk</label>
                            <input type="time" name="jam_masuk" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Jam Keluar</label>
                            <input type="time" name="jam_keluar" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Tipe</label>
                            <select name="tipe" class="form-select" required>\
                                <option value="" disabled selected> - Silahkan pilih - </option>
                                <option value="1">Translator</option>
                                <option value="2">Karyawan</option>
                                <option value="3">Karyawan Shift</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Keterangan</label>
                            <textarea name="keterangan" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($datas as $data)
    <div class="modal fade" id="editWaktuAbsen{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Content</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.waktu_absen', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    @csrf
                    {{ method_field('patch') }}
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="small mb-1">Shift</label>
                            <select name="nama_shift" class="form-select" required>
                                <option value="{{ $data->nama_shift }}" selected>{{ $data->nama_shift }}</option>
                                <option value="Pagi">Pagi</option>
                                <option value="Sore">Sore</option>
                                <option value="Malam">Malam</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Jam Masuk</label>
                            <input type="time" name="jam_masuk" class="form-control" value="{{ $data->jam_masuk }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Jam Keluar</label>
                            <input type="time" name="jam_keluar" class="form-control" value="{{ $data->jam_keluar }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Tipe</label>
                            <select name="tipe" class="form-select" required>\
                                <option value="" disabled selected> - Silahkan pilih - </option>
                                <option value="1">Translator</option>
                                <option value="2">Karyawan</option>
                                <option value="3">Karyawan Shift</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Keterangan</label>
                            <textarea name="keterangan" class="form-control" cols="30" rows="10">{{ $data->keterangan }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($datas as $data)
    <div class="modal fade" id="delWaktuAbsen{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus waktu kerja</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroy.dashboard', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        Apa kamu yakin ingin menghapus data ini ({{ $data->nama_shift }})?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Add</button>
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
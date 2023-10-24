<x-app-layout title="Reminder">
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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Reminder
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <x-message />
        <nav class="nav nav-borders">
            <a class="nav-link {{ (request()->segment(2) == 'daftar-pengingat') ? 'active' : '' }} ms-0" href="/roster/daftar-pengingat">Reminder</a>
            <a class="nav-link {{ (request()->is('roster')) ? 'active' : '' }} ms-0" href="/roster">Roster</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
            <div class="col-lg-12 mb-2">
                <form action="/roster/daftar-pengingat" method="get">
                    @csrf
                    <div class="card">
                        <div class="card-body" style="overflow-x: auto;">
                            <select name="status_pengajuan" id="" class="form-select">
                                <option value="" disabled selected>Select Submission Status :</option>
                                <option value="Belum Pengajuan">Not submit</option>
                                <option value="Jatuh Tempo">Due date</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Completed</option>
                            </select>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-light text-primary" type="submit">
                                    <i class="me-1" data-feather="search"></i>
                                    Filter
                                </button>
                                <a class="btn btn-sm btn-light text-primary" href="/roster/daftar-pengingat">
                                    <i class="me-1" data-feather="trash"></i>
                                    Clean filters
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x: auto;">
                        <table id="datatablesSimple" class="table table-hover">
                            <thead>
                                <tr>
                                    @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Action</th>
                                    <th>Employee name</th>
                                    <th>Msg</th>
                                    <th>Leave date</th>
                                    <th>Paid leave</th>
                                    <th>Period</th>
                                    @endif
                                </tr>
                                @if(strtolower(Auth::user()->job->permission_role ?? '') != 'administrator')
                                <tr>
                                    <th>No</th>
                                    <th>Pesan</th>
                                </tr>
                                @endif
                            </thead>
                            <tbody>
                                @foreach($datas as $data)
                                @php
                                $tahun = 0;
                                $bulan = 0;
                                $tgl_cuti = new DateTime($data->tanggal_cuti);
                                $tgl_sekarang = new DateTime(today());
                                $tgl_jt_tempo = $tgl_sekarang->diff($tgl_cuti)->days;

                                if($tgl_sekarang->diff($tgl_cuti)->m > 0){
                                $tahun = $tgl_sekarang->diff($tgl_cuti)->y;
                                $bulan = $tgl_sekarang->diff($tgl_cuti)->m;
                                }

                                $role = Auth::user()->job->permission_role ?? '';
                                @endphp

                                @if(strtolower($role) == 'administrator')
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>
                                        {{ $data->nik_karyawan }} <br>
                                        @if($data->status_pengajuan === NULL)
                                        <span class="badge bg-warning-soft text-warning">Not submitted</span>
                                        @endif
                                        @if((strtolower($data->status_pengajuan) === 'proses') && ($tgl_jt_tempo > 0))
                                        <span class="badge bg-primary-soft text-primary">Proses</span>
                                        @endif
                                        @if(strtolower($data->status_pengajuan) == 'selesai' && $tgl_jt_tempo > 0)
                                        <span class="badge bg-success-soft text-success">Completed</span>
                                        @endif
                                        @if($data->status_pengajuan == NULL || strtolower($data->status_pengajuan) && $tgl_jt_tempo > 0 && strtolower($data->status_pengajuan) != 'selesai')
                                        @if($tgl_jt_tempo >= 14 && $tahun > 0)
                                        <span class="badge bg-danger-soft text-danger">Expired {{ $tahun }} years {{ $bulan }} months</span>
                                        @endif
                                        @if($tgl_cuti < $tgl_sekarang && $tgl_jt_tempo < 365) <span class="badge bg-danger-soft text-danger">Expired {{ $tgl_jt_tempo }} day ago</span>
                                            @endif
                                            @if($tgl_cuti > $tgl_sekarang)
                                            <span class="badge bg-info-soft text-info">Expired in {{ $tgl_jt_tempo }} days</span>
                                            @endif
                                            @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('update.statusPengajuan', $data->id) }}" method="POST">
                                            @csrf
                                            {{ @method_field('patch') }}
                                            <input type="hidden" name="status_pengajuan" value="Proses">
                                            <button type="submit" class="btn btn-primary btn-sm mb-2">Proses</button>
                                        </form>
                                        <form action="{{ route('update.statusPengajuan', $data->id) }}" method="POST">
                                            @csrf
                                            {{ @method_field('patch') }}
                                            <input type="hidden" name="status_pengajuan" value="Selesai">
                                            <button type="submit" class="btn btn-success btn-sm">Complete</button>
                                        </form>
                                    </td>
                                    <td>{{ $data->karyawan->nama_karyawan ?? '' }}</td>
                                    <td>{{ $data->pesan }}</td>
                                    <td>{{ $data->tanggal_cuti }}</td>
                                    <td>Cuti Ke-{{ $data->periode_mingguan }}</td>
                                    <td>{{ $data->periode->awal_periode }} - {{ $data->periode->akhir_periode }}</td>
                                </tr>
                                @endif

                                @if(strtolower($role) != 'administrator')
                                <tr>
                                    <td>{{ ++$no }}
                                        <br>
                                        @if($data->status_pengajuan === NULL)
                                        <span class="badge bg-warning-soft text-warning">Not submitted</span>
                                        @endif
                                        @if((strtolower($data->status_pengajuan) === 'proses') && ($tgl_jt_tempo > 0))
                                        <span class="badge bg-primary-soft text-primary">Proses</span>
                                        @endif
                                        @if(strtolower($data->status_pengajuan) == 'selesai' && $tgl_jt_tempo > 0)
                                        <span class="badge bg-success-success text-success">Completed</span>
                                        @endif
                                        @if($data->status_pengajuan == NULL || strtolower($data->status_pengajuan) && $tgl_jt_tempo > 0 && strtolower($data->status_pengajuan) != 'selesai')
                                        @if($tgl_jt_tempo >= 14 && $tahun > 0)
                                        <span class="badge bg-danger-soft text-danger">Expired {{ $tahun }} years {{ $bulan }} months</span>
                                        @endif
                                        @if($tgl_cuti < $tgl_sekarang && $tgl_jt_tempo < 365) <span class="badge bg-danger">Expired {{ $tgl_jt_tempo }} day ago</span>
                                            @endif
                                            @if($tgl_cuti > $tgl_sekarang)
                                            <span class="badge bg-info-soft text-info">Expired in{{ $tgl_jt_tempo }} days</span>
                                            @endif
                                            @endif
                                    </td>
                                    <td>{{ $data->pesan }}</td>
                                </tr>
                                @endif

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
<x-app-layout title="Daftar Pengingat">
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
                            Data Pengingat
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <x-message />
        <div class="row">
            @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
            <div class="col-lg-12 mb-2">
                <form action="/roster/daftar-pengingat" method="get">
                    @csrf
                    <div class="card">
                        <div class="card-body" style="overflow-x: auto;">
                            <select name="status_pengajuan" id="" class="form-select">
                                <option value="" disabled selected>Pilih Status Pengajuan :</option>
                                <option value="Belum Pengajuan">Belum Pengajuan</option>
                                <option value="Jatuh Tempo">Jatuh Tempo</option>
                                <option value="Proses">Proses</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary mt-2">Filter Status</button>
                            <a href="/roster/daftar-pengingat" class="btn btn-sm btn-purple mt-2">Buka Filter</a>
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
                                    <th>No</th>
                                    <th>NIK</th>
                                    @if(strtolower(Auth::user()->job->permission_role ?? '') == 'administrator')
                                    <th>Proses</th>
                                    <th>Nama Karyawan</th>
                                    @endif
                                    <th>Pesan</th>
                                    <th>Tgl Cuti</th>
                                    <th>Cuti</th>
                                    <th>Tahun</th>
                                </tr>
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
                                        <span class="badge bg-warning">Belum Pengajuan</span>
                                        @endif
                                        @if((strtolower($data->status_pengajuan) === 'proses') && ($tgl_jt_tempo > 0))
                                        <span class="badge bg-primary">Proses</span>
                                        @endif
                                        @if(strtolower($data->status_pengajuan) == 'selesai' && $tgl_jt_tempo > 0)
                                        <span class="badge bg-success">Selesai</span>
                                        @endif
                                        @if($data->status_pengajuan == NULL || strtolower($data->status_pengajuan) && $tgl_jt_tempo > 0 && strtolower($data->status_pengajuan) != 'selesai')
                                        @if($tgl_jt_tempo >= 14 && $tahun > 0)
                                        <span class="badge bg-danger">Expired {{ $tahun }} tahun {{ $bulan }} bulan</span>
                                        @endif
                                        @if($tgl_cuti < $tgl_sekarang && $tgl_jt_tempo < 365) <span class="badge bg-danger">Expired {{ $tgl_jt_tempo }} hari lalu</span>
                                            @endif
                                            @if($tgl_cuti > $tgl_sekarang)
                                            <span class="badge bg-info">Expired {{ $tgl_jt_tempo }} hari lagi</span>
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
                                            <button type="submit" class="btn btn-success btn-sm">Selesai</button>
                                        </form>
                                    </td>
                                    <td>{{ getName($data->nik_karyawan) }}</td>
                                    <td>{{ $data->pesan }}</td>
                                    <td>{{ $data->tanggal_cuti }}</td>
                                    <td>Cuti Ke-{{ $data->periode_mingguan }}</td>
                                    <td>{{ $data->periode->awal_periode }} - {{ $data->periode->akhir_periode }}</td>
                                </tr>
                                @endif

                                @if(strtolower($role) != 'administrator')
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>
                                        {{ $data->nik_karyawan }} <br>
                                        @if($data->status_pengajuan === NULL)
                                        <span class="badge bg-warning">Belum Pengajuan</span>
                                        @endif
                                        @if((strtolower($data->status_pengajuan) === 'proses') && ($tgl_jt_tempo > 0))
                                        <span class="badge bg-primary">Proses</span>
                                        @endif
                                        @if(strtolower($data->status_pengajuan) == 'selesai' && $tgl_jt_tempo > 0)
                                        <span class="badge bg-success">Selesai</span>
                                        @endif
                                        @if($data->status_pengajuan == NULL || strtolower($data->status_pengajuan) && $tgl_jt_tempo > 0 && strtolower($data->status_pengajuan) != 'selesai')
                                        @if($tgl_jt_tempo >= 14 && $tahun > 0)
                                        <span class="badge bg-danger">Expired {{ $tahun }} tahun {{ $bulan }} bulan</span>
                                        @endif
                                        @if($tgl_cuti < $tgl_sekarang && $tgl_jt_tempo < 365) <span class="badge bg-danger">Expired {{ $tgl_jt_tempo }} hari lalu</span>
                                            @endif
                                            @if($tgl_cuti > $tgl_sekarang)
                                            <span class="badge bg-info">Expired {{ $tgl_jt_tempo }} hari lagi</span>
                                            @endif
                                            @endif
                                    </td>
                                    <td>{{ $data->pesan }}</td>
                                    <td>{{ $data->tanggal_cuti }}</td>
                                    <td>Cuti Ke-{{ $data->periode_mingguan }}</td>
                                    <td>{{ $data->periode->awal_periode }} - {{ $data->periode->akhir_periode }}</td>
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
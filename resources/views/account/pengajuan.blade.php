<x-app-layout title="Information">

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
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Informasi
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-blue" href="/account/profile">
                            <i class="me-1" data-feather="x"></i>
                            Tutup
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <x-nav-account />
        <hr class="mt-0 mb-4" />
        <x-message />
        <div class="row">
            @foreach($datas as $data)
            <div class="col-xl-4 mb-2">
                <!-- Dashboard example card 3-->
                <a class="card lift-sm h-100" data-bs-toggle="collapse" href="#collapsePengajuan{{$data->id}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="feather-xl text-primary mb-3" data-feather="layout"></i>
                                <h5>Pengajuan {{ $data->tipe }} | {{ date('d-m-Y', strtotime($data->tanggal)) }}</h5>
                                <div class="text-muted small">{{ $data->keterangan }}</div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="collapse multi-collapse" id="collapsePengajuan{{$data->id}}">
                <div class="card card-body mb-2">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Pemohon</div>
                                <div class="timeline-item-marker-indicator bg-primary-soft text-primary"><i data-feather="flag"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-primary">{{ $data->karyawan->nama_karyawan }}</h5>
                                        {{ $data->keterangan }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(strtolower($data->status_hrd) == 'diterima')
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Disetujui</div>
                                <div class="timeline-item-marker-indicator bg-success-soft text-success"><i data-feather="edit-3"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-success">Human Resource</h5>
                                        Telah disetujui dan diberikan izin cuti selama {{ $data->jumlah }} hari
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">{{ ucfirst($data->status_hrd) == 'Menunggu' ? 'Menunggu' : 'Ditolak' }}</div>
                                <div class="timeline-item-marker-indicator bg-success-soft text-success"><i data-feather="edit-3"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-success">Human Resource</h5>
                                        {{ ucfirst($data->status_hrd) == 'Menunggu' ? 'Menunggu konfirmasi' : 'Pengajuan ditolak' }} dari Human Resource
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(strtolower($data->status_hod) == 'diterima')
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Disetujui</div>
                                <div class="timeline-item-marker-indicator bg-secondary-soft text-secondary"><i data-feather="map"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-secondary">Head Of Departemen</h5>
                                        Telah diberikan izin cuti dan berhak cuti pada tanggal {{ $data->tanggal_mulai }} dan masa cuti
                                        akan berakhir pada tanggal {{ $data->tanggal_berakhir }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">{{ ucfirst($data->status_hod) == 'Menunggu' ? 'Menunggu' : 'Ditolak' }}</div>
                                <div class="timeline-item-marker-indicator bg-secondary-soft text-secondary"><i data-feather="map"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-secondary">Head Of Departemen</h5>
                                        {{ ucfirst($data->status_hod) == 'Menunggu' ? 'Menunggu konfirmasi dari ' : 'Pengajuan ditolak ' }} Head of Departemen
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(strtolower($data->status_penanggung_jawab) == 'diterima')
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Disetujui</div>
                                <div class="timeline-item-marker-indicator bg-danger-soft text-danger"><i data-feather="map"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-danger">Penanggung Jawab Site</h5>
                                        Telah diberikan izin cuti dan berhak cuti pada tanggal {{ $data->tanggal_mulai }} dan masa cuti
                                        akan berakhir pada tanggal {{ $data->tanggal_berakhir }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">{{ ucfirst($data->status_penanggung_jawab) == 'Menunggu' ? 'Menunggu' : 'Ditolak' }}</div>
                                <div class="timeline-item-marker-indicator bg-danger-soft text-danger"><i data-feather="map"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-danger">Penanggung Jawab Site</h5>
                                        {{ ucfirst($data->status_penanggung_jawab) == 'Menunggu' ? 'Menunggu konfirmasi dari ' : 'Pengajuan ditolak ' }} Penanggung Jawab Site
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if(strtolower($data->status_penanggung_jawab) == 'diterima' && strtolower($data->status_hod) == 'diterima' && strtolower($data->status_hrd) == 'diterima')
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Selesai</div>
                                <div class="timeline-item-marker-indicator bg-warning-soft text-warning"><i data-feather="send"></i></div>
                            </div>
                            <div class="timeline-item-content pt-0">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="text-warning">Pengajuan diterima</h5>
                                        Cuti telah disetujui
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
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
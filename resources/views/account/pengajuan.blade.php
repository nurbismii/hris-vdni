<x-app-layout title="Pengajuan Cuti">

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
            <div class="col-lg-12 mb-2">
                <!-- Dashboard example card 3-->
                <a class="card lift-sm h-100" data-bs-toggle="collapse" href="#collapsePengajuan{{$data->id}}" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">
                    <div class="card-body d-flex justify-content-center flex-column">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="me-3">
                                <i class="feather-xl text-primary mb-3" data-feather="layout"></i>
                                <h5>Pengajuan {{ $data->tipe }} | {{ date('d-m-Y', strtotime($data->tanggal)) }}</h5>
                                <div class="text-muted small">{{ $data->keterangan }}</div>
                            </div>
                            <img src="{{ asset('dokumentasi/' . $data->nik_karyawan . '/' . $data->foto) }}" style="width: 8rem" />
                        </div>
                    </div>
                </a>
            </div>
            <div class="collapse multi-collapse" id="collapsePengajuan{{$data->id}}">
                <div class="card card-body mb-2">
                    <div class="timeline timeline">
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Pemohon</div>
                                <div class="timeline-item-marker-indicator">
                                    @if($data->pemohon == 'Menunggu')
                                    2
                                    @else
                                    <i data-feather="check"></i>
                                    @endif
                                </div>
                            </div>
                            @if($data->pemohon == 'Menunggu')
                            <div class="timeline-item-content">Saat ini...</div>
                            @else
                            <div class="timeline-item-content">Syarat terpenuhi.</div>
                            @endif
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">HRD</div>
                                <div class="timeline-item-marker-indicator">
                                    @if($data->status_hrd == 'Menunggu')
                                    2
                                    @else
                                    <i data-feather="check"></i>
                                    @endif
                                </div>
                            </div>
                            @if($data->status_hrd == 'Menunggu')
                            <div class="timeline-item-content">Saat ini...</div>
                            @else
                            <div class="timeline-item-content">Syarat terpenuhi.</div>
                            @endif
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">HOD</div>
                                <div class="timeline-item-marker-indicator">
                                    @if($data->status_hod == 'Menunggu')
                                    3
                                    @else
                                    <i data-feather="check"></i>
                                    @endif
                                </div>
                            </div>
                            @if($data->status_hrd == 'Diterima' && $data->status_hod == 'Menunggu')
                            <div class="timeline-item-content">Saat ini.</div>
                            @elseif($data->status_hod == 'Diterima' && $data->status_hrd == 'Diterima')
                            <div class="timeline-item-content">Syarat terpenuhi.</div>
                            @else
                            <div class="timeline-item-content">Langkah selanjutnya...</div>
                            @endif
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Penanggung Jawab</div>
                                <div class="timeline-item-marker-indicator">
                                    @if($data->status_penanggung_jawab == 'Menunggu')
                                    4
                                    @else
                                    <i data-feather="check"></i>
                                    @endif
                                </div>
                            </div>
                            @if($data->status_hrd == 'Diterima' && $data->status_hod == 'Diterima' && $data->status_penanggung_jawab == 'Menunggu')
                            <div class="timeline-item-content">Saat ini.</div>
                            @elseif($data->status_hod == 'Menunggu' && $data->status_hrd == 'Menunggu' && $data->status_penanggung_jawab == 'Menunggu')
                            <div class="timeline-item-content">Langkah selanjutnya...</div>
                            @else
                            <div class="timeline-item-content">Langkah selanjutnya...</div>
                            @endif
                        </div>
                        <div class="timeline-item mb-3">
                            <div class="timeline-item-marker">
                                <div class="timeline-item-marker-text">Selesai</div>
                                <div class="timeline-item-marker-indicator">
                                    @if($data->status_penanggung_jawab == 'Menunggu')
                                    5
                                    @else
                                    <i data-feather="check"></i>
                                    @endif
                                </div>
                            </div>
                            @if($data->status_hrd == 'Diterima' && $data->status_hod == 'Diterima' && $data->status_penanggung_jawab == 'Diterima')
                            <div class="timeline-item-content">Saat ini.</div>
                            @elseif($data->status_hod == 'Menunggu' && $data->status_hrd == 'Menunggu' && $data->status_penanggung_jawab == 'Menunggu')
                            <div class="timeline-item-content">Langkah selanjutnya...</div>
                            @else
                            <div class="timeline-item-content">Langkah selanjutnya...</div>
                            @endif
                        </div>
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
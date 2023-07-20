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
        <!-- Account page navigation-->
        <x-nav-account />
        <hr class="mt-0 mb-4" />
        <x-message />
        <!-- Billing history card-->
        <div class="card mb-4">
            <div class="card-header">Riwayat Pengajuan</div>
            <div class="card-body p-0">
                <div class="table-responsive d table-billing-history" style="overflow-x:auto;">
                    <table class="table mb-0 accordion table-condensed table-stripe">
                        <thead>
                            <tr>
                                <th class="border-gray-200" scope="col">Pengajuan</th>
                                <th class="border-gray-200" scope="col">Mulai</th>
                                <th class="border-gray-200" scope="col">Berakhir</th>
                                <th class="border-gray-200" scope="col">Cuti</th>
                                <th class="border-gray-200" scope="col">Status HRD</th>
                                <th class="border-gray-200" scope="col">Status HOD</th>
                                <th class="border-gray-200" scope="col">Status Penanggung Jawab</th>
                                <th class="border-gray-200" scope="col">Tipe</th>
                                <th class="border-gray-200" scope="col">Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($datas as $data)
                            <tr class="text-center" data-bs-toggle="collapse" data-bs-target="#accor{{$data->id}}">
                                <td>{{ date('d F Y', strtotime($data->tanggal)) }}</td>
                                <td>{{ date('d F Y', strtotime($data->tanggal_mulai)) }}</td>
                                <td>{{ date('d F Y', strtotime($data->tanggal_berakhir)) }}</td>
                                <td>{{ $data->jumlah }}</td>
                                <td>{{ ucfirst($data->status_hrd) == '' ? 'Menunggu' : ucfirst($data->status_hrd) }}</td>
                                <td>{{ ucfirst($data->status_hod) == '' ? 'Menunggu' : ucfirst($data->status_hod) }}</td>
                                <td>{{ ucfirst($data->status_penanggung_jawab) == '' ? 'Menunggu' : ucfirst($data->status_penanggung_jawab) }}</td>
                                <td>{{ ucfirst($data->tipe) }}</td>
                                <td>
                                    <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target=""><i data-feather="corner-right-down"></i></a>
                                </td>
                            </tr>
                            <tr class="collapse accordion-collapse" id="accor{{$data->id}}" data-bs-parent=".table">
                                <td colspan="9">
                                    <!-- Step Component Example -->
                                    <!-- Styled timeline component example -->
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
                                                <div class="timeline-item-marker-text">{{ strtoupper($data->status_hrd) == '' ? 'Menunggu' : 'Ditolak' }}</div>
                                                <div class="timeline-item-marker-indicator bg-success-soft text-success"><i data-feather="edit-3"></i></div>
                                            </div>
                                            <div class="timeline-item-content pt-0">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="text-success">Human Resource</h5>
                                                        {{ strtoupper($data->status_hrd) == '' ? 'Menunggu konfirmasi' : 'Pengajuan ditolak' }} dari Human Resource
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
                                                <div class="timeline-item-marker-text">{{ strtoupper($data->status_hrd) == '' ? 'Menunggu' : 'Ditolak' }}</div>
                                                <div class="timeline-item-marker-indicator bg-secondary-soft text-secondary"><i data-feather="map"></i></div>
                                            </div>
                                            <div class="timeline-item-content pt-0">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="text-secondary">Head Of Departemen</h5>
                                                        Menunggu konfirmasi dari Head of Departemen
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
                                                <div class="timeline-item-marker-text">{{ strtoupper($data->status_hrd) == '' ? 'Menunggu' : 'Ditolak' }}</div>
                                                <div class="timeline-item-marker-indicator bg-danger-soft text-danger"><i data-feather="map"></i></div>
                                            </div>
                                            <div class="timeline-item-content pt-0">
                                                <div class="card shadow-sm">
                                                    <div class="card-body">
                                                        <h5 class="text-danger">Penanggung Jawab Site</h5>
                                                        Menunggu konfirmasi dari Penanggung Jawab Site
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
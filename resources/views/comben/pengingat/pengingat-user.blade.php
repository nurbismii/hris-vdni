<x-app-layout>
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @endpush

    <div class="container-xl px-4 mt-4">

        <div class="card card-header-actions mb-4">
            <div class="card-header">
                Pengingat Cuti
            </div>
            <div class="card-body px-0">
                <!-- Payment method 1-->
                @forelse($datas as $data)
                <div class="d-flex align-items-center justify-content-between px-4">
                    <div class="d-flex align-items-center">
                        <i class="fa fa-bell fa-2x cc-color-visa"></i>
                        <div class="ms-4">
                            <div class="small">{{ $data->nik_karyawan }}</div>
                            <div class="small">{{ $data->pesan }}</div>
                            <span class="text-xs text-muted">Jatuh Tempo {{ date('d F Y', strtotime($data->tanggal_cuti)) }}</span>
                        </div>
                    </div>
                    <div class="ms-4 small">
                        <div class="badge bg-light text-dark me-3">{{ date('H:i', strtotime($data->updated_at)) }}</div>
                    </div>
                </div>
                <hr />
                @empty
                <div class="text-center text-muted">
                    Pengingat belum tersedia
                </div>
                @endforelse
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
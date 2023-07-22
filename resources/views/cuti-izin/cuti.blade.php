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
        <div class="container-xl px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="edit-3"></i></div>
                            Pengajuan Cuti
                        </h1>
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
                <div class="card mb-4">
                    <div class="card-header">Formulir Cuti</div>
                    <div class="card-body">
                        <form action="/pengajuan/store-cuti" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row gx-3 mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="small mb-2">Nama</label>
                                    <input class="form-control" type="text" name="nama" value="{{$data->nama_karyawan}}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-2">Departemen</label>
                                    <input class="form-control" name="departemen" type="email" value="{{$data->divisi->departemen->departemen}}" readonly />
                                </div>
                            </div>
                            <div class="row gx-3 mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="small mb-2">NIK</label>
                                    <input class="form-control" name="nik" type="text" value="{{$data->nik}}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-2">Tanggal Pengajuan</label>
                                    <input class="form-control" name="tanggal_pengajuan" type="text" value="{{ $tanggal_sekarang }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="small mb-2">Alasan Cuti</label>
                                <textarea name="keterangan" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="row gx-3 mb-2">
                                <div class="col-md-5 mb-2">
                                    <label class="small mb-2">Tanggal Mulai Cuti</label>
                                    <input class="form-control" name="tgl_mulai_cuti" type="date" />
                                </div>
                                <div class="col-md-5 mb-2">
                                    <label class="small mb-2">Tanggal Akhir Cuti</label>
                                    <input class="form-control" name="tgl_akhir_cuti" type="date" />
                                </div>
                                <div class="col-md-2">
                                    <label class="small mb-2">Sisa Cuti</label>
                                    <input name="sisa_cuti" class="form-control" type="number" value="4" max="12" disabled />
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="small mb-2">Foto Pendukung</label>
                                <input type="file" name="foto_pendukung" class="form-control">
                            </div>
                            <div class="text-center d-grid">
                                <button class="btn btn-primary btn-sm" type="submit">Kirim</button>
                            </div>
                        </form>
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
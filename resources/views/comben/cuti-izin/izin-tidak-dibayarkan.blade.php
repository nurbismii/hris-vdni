<x-app-layout title="Izin tidak dibayarkan">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2.select2-container.select2-container--classic {
            width: 100% !important;
        }
    </style>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="archive"></i></div>
                            Cuti,Paid leave dan Unpaid leave
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-blue" href="/">
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
        <!-- Wizard card example with navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link {{ (request()->segment(2) == 'cuti') ? 'active' : '' }} ms-0" href="/karyawan/cuti">Cuti</a>
            <!-- <a class="nav-link {{ (request()->segment(2) == 'cuti-roster') ? 'active' : '' }} ms-0" href="/karyawan/cuti-roster">Cuti Roster</a> -->
            <a class="nav-link {{ (request()->segment(2) == 'izin-dibayarkan') ? 'active' : '' }} ms-0" href="/karyawan/izin-dibayarkan">Izin berbayar</a>
            <a class="nav-link {{ (request()->segment(2) == 'izin-tidak-dibayarkan') ? 'active' : '' }} ms-0" href="/karyawan/izin-tidak-dibayarkan">Izin tidak berbayar</a>
        </nav>
        <hr class="mt-0 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-xxl-6 col-xl-8">
                        <h3 class="text-primary text-center">Formulir izin tidak dibayarkan</h3>
                        <h5 class="card-title mb-4">
                            <img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;" class="">
                        </h5>
                        <form action="/pengajuan-karyawan/store-izin-tidak-dibayarkan" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- <div class="mb-3">
                                <select class="form-select search" name="search" id="nik"></select>
                            </div> -->
                            <div class="row gx-3 mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="small mb-2">Nama</label>
                                    <input class="form-control" type="text" name="nama" id="nama_karyawan" value="{{ Auth::user()->employee->nama_karyawan }}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-2">Departemen</label>
                                    <input class="form-control" name="departemen" type="email" id="departemen" value="{{ Auth::user()->employee->divisi->departemen->departemen }}" readonly />
                                </div>
                            </div>
                            <div class="row gx-3 mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="small mb-2">NIK</label>
                                    <input class="form-control nik_karyawan" name="nik" type="text" value="{{ Auth::user()->employee->nik }}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-2">Tanggal Pengajuan</label>
                                    <input class="form-control" name="tanggal_pengajuan" type="text" value="{{ date('Y-m-d') }}" readonly />
                                </div>
                            </div>
                            <div class="col-md-12 mb-2">
                                <label class="small mb-2">Alasan izin</label>
                                <textarea name="keterangan" class="form-control" cols="30" rows="10"></textarea>
                            </div>
                            <div class="row gx-3 mb-2">
                                <div class="col-md-6 mb-2">
                                    <label class="small mb-2">Tanggal mulai izin</label>
                                    <input class="form-control" name="tgl_mulai_cuti" type="date" required />
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label class="small mb-2">Tanggal akhir izin</label>
                                    <input class="form-control" name="tgl_akhir_cuti" type="date" required />
                                </div>
                            </div>
                            <hr class="my-4" />
                            <div class="d-grid">
                                <button class="btn btn-primary" type="submit">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <x-toastr />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript">
        $('.search').select2({
            width: 'resolve',
            theme: 'classic',
            placeholder: 'Search employee...',
            ajax: {
                url: '/api/hrcorner/search-employee',
                dataType: 'json',
                delay: 250,
                processResults: function(data) {
                    return {
                        results: $.map(data, function(item) {
                            return {
                                text: item.nik + ' - ' + item.nama_karyawan,
                                id: item.nik
                            }
                        })
                    };
                },
                cache: true
            }
        });

        $('#nik').on('change', function() {
            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: '/api/hrcorner/detail-employee/' + id,
                    type: "GET",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data) {
                            $('.nik_karyawan').val(data.nik);
                            $('#nama_karyawan').val(data.nama_karyawan);
                            $('#departemen').val(data.departemen);
                            $('#divisi').val(data.nama_divisi);
                            $('#posisi').val(data.posisi);
                            $('#jabatan').val(data.jabatan);
                            $('#sisa_cuti').val(data.sisa_cuti);
                        }
                    }
                });
            }
        });
    </script>
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
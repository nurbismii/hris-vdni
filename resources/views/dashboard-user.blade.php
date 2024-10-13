<x-app-layout title="Dashboard">
    @push('styles')
    <script src="https://maps.googleapis.com/maps/api/js"></script>
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

    <style>
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        h1 {
            font-size: 2.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
        }

        .text-primary {
            color: #007bff !important;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .card .fa {
            color: #6c757d;
        }

        .fw-bold {
            font-weight: bold;
        }

        .small {
            font-size: 0.875rem;
        }

        .text-gray-700 {
            color: #6c757d;
        }

        .text-white-75 {
            color: rgba(255, 255, 255, 0.75);
        }

        .feather-xl {
            font-size: 1.75rem;
        }

        .gap-2>.btn {
            margin-top: 1rem;
        }

        .d-grid {
            gap: 1rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mt-5 {
            margin-top: 3rem;
        }
    </style>
    @endpush

    <div class="container-xl px-4 mt-5">
        <div class="d-flex justify-content-between align-items-center flex-column flex-sm-row mb-4">
            <div class="me-4 mb-3 mb-sm-0">
                <h1 class="mb-0">Dashboard</h1>
                <div class="small">
                    <span class="fw-bold text-primary">{{ $hari_ini }}</span>
                    &middot; {{ date('d F Y', strtotime(today())) }} &middot;
                </div>
            </div>
        </div>

        <!-- Dashboard Welcome Card -->
        <div class="row">
            <!-- Card Selamat Datang -->
            <div class="col-lg-6 mb-4">
                <div class="card card-waves h-100">
                    <div class="card-body p-5">
                        <div class="row align-items-center">
                            <div class="col">
                                <h2 class="text-primary">Selamat Datang, {{ ucwords(strtolower(Auth::user()->employee->nama_karyawan)) }}!</h2>
                                <p class="text-gray-700">{{ $data->description }}</p>
                            </div>
                            <div class="col d-none d-lg-block">
                                <img class="img-fluid" src="assets/img/illustrations/statistics.svg" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absen Status Cards + Presensi Button -->
            <div class="col-lg-6">
                <div class="row">
                    <!-- Card Masuk -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-dark text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-white-75 small">Masuk</div>
                                        <div class="text-lg fw-bold">{{ $absen_hari_ini->jam_masuk ?? '-- : -- : --' }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="check-square"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Keluar -->
                    <div class="col-md-6 mb-3">
                        <div class="card bg-dark text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-white-75 small">Keluar</div>
                                        <div class="text-lg fw-bold">{{ $absen_hari_ini->jam_pulang ?? '-- : -- : --' }}</div>
                                    </div>
                                    <i class="feather-xl text-white-50" data-feather="check-square"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Button Presensi -->
                    <div class="col-12 mb-3">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" onclick="getLocation()" data-bs-target="#addAbsen">
                                <i class="me-1" data-feather="map"></i> Presensi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Info Widgets -->
        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-3">Departemen</div>
                                <div class="h5">{{ $divisi->departemen->departemen }}</div>
                            </div>
                            <i class="fas fa-building fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-secondary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-primary mb-3">Divisi</div>
                                <div class="h5">{{ $divisi->nama_divisi }}</div>
                            </div>
                            <i class="fas fa-network-wired fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-success mb-3">Jabatan</div>
                                <div class="h5">{{ Auth::user()->employee->jabatan }}</div>
                            </div>
                            <i class="fas fa-id-card fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-start-info h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-info mb-3">Posisi</div>
                                <div class="h5">{{ Auth::user()->employee->posisi }}</div>
                            </div>
                            <i class="fas fa-id-card fa-2x text-gray-200"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lokasi saat ini</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4" id="googleMap" style="width:100%;height:400px;"></div>
                    <form action="{{ route('store.absensi') }}" method="POST" class="nav flex-column" id="stickyNav">
                        @csrf
                        <input type="hidden" name="nik_karyawan" value="{{ Auth::user()->nik_karyawan }}">
                        <input type="hidden" name="lat" id="latStore">
                        <input type="hidden" name="lng" id="lngStore">
                        @if($jam_masuk == 'Belum Absen')
                        <button class="btn btn-light text-primary" type="submit">
                            <i class="me-1" data-feather="log-in"></i>
                            Masuk
                        </button>
                        @endif
                    </form>
                    @isset($absen_hari_ini->id)
                    <form action="{{ route('update.absensi', $absen_hari_ini->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                        @csrf
                        {{ method_field('patch') }}
                        <input type="hidden" name="nik_karyawan" value="{{ Auth::user()->nik_karyawan }}">
                        <input type="hidden" name="lat" id="latUpdate">
                        <input type="hidden" name="lng" id="lngUpdate">
                        <button class="btn btn-light text-primary" type="submit">
                            <i class="me-1" data-feather="log-out"></i>
                            Keluar
                        </button>
                    </form>
                    @endisset
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light text-blue btn-sm" type="button" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal absen -->

    @push('scripts')
    <x-toastr />
    <script>
        var lat = document.getElementById("lat");
        var lng = document.getElementById("lng");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolokasi tidak mendukung browser ini!";
            }
        }

        function showPosition(position) {

            lat = position.coords.latitude;
            lng = position.coords.longitude;

            document.getElementById("latStore").value = lat;
            document.getElementById("lngStore").value = lng;

            var propertiPeta = {
                center: new google.maps.LatLng(lat, lng),
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var peta = new google.maps.Map(document.getElementById("googleMap"), propertiPeta);
            // membuat Marker
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat, lng),
                map: peta
            });

            document.getElementById("latUpdate").value = lat;
            document.getElementById("lngUpdate").value = lng;
        }
        google.maps.event.addDomListener(window, 'load');
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
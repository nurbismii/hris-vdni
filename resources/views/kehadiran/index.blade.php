<x-app-layout title="Users">
    @push('styles')
    <script src="https://maps.googleapis.com/maps/api/js"></script>
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
                            Data Kehadiran
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
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Jam Masuk</div>
                                @if($jam_masuk == 'Belum Absen')
                                <div class="text-lg fw-bold"> -- : -- : -- </div>
                                @endif
                                @isset($absen_hari_ini->jam_masuk)
                                <div class="text-lg fw-bold">{{ $absen_hari_ini->jam_masuk }}</div>
                                @endisset
                            </div>
                            <i class="feather-xl text-white-50" data-feather="check-square"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 mb-4">
                <div class="card bg-dark text-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="me-3">
                                <div class="text-white-75 small">Jam Keluar</div>
                                @if($jam_pulang == 'Belum Absen')
                                <div class="text-lg fw-bold"> -- : -- : -- </div>
                                @endif
                                @isset($absen_hari_ini->jam_pulang )
                                <div class="text-lg fw-bold">{{ $absen_hari_ini->jam_pulang }}</div>
                                @endisset
                            </div>
                            <i class="feather-xl text-white-50" data-feather="check-square"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-block rounded-pill btn-primary text-white mb-3" data-bs-toggle="modal" onclick="getLocation()" data-bs-target="#addAbsen">ABSEN</button>
        </div>
        <div class="card">
            <div class="card-body" style="overflow-x: auto;">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam Masuk</th>
                            <th>Jam Keluar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $row)
                        <tr>
                            <td>{{ date('d F Y', strtotime($row->created_at)) }}</td>
                            <td>{{ $row->jam_masuk }}</td>
                            <td>{{ $row->jam_pulang }}</td>
                            <td>{{ $row->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal absen -->
    <div class="modal fade" id="addAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Lokasi Map</h5>
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
                        <button type="submit" class="btn btn-success btn-sm" type="button">Masuk</button>
                        @endif
                    </form>
                    @isset($absen_hari_ini->id)
                    <form action="{{ route('update.absensi', $absen_hari_ini->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                        @csrf
                        {{ method_field('patch') }}
                        <input type="hidden" name="nik_karyawan" value="{{ Auth::user()->nik_karyawan }}">
                        <input type="hidden" name="lat" id="latUpdate">
                        <input type="hidden" name="lng" id="lngUpdate">
                        <button type="submit" class="btn btn-danger btn-sm" type="button">Keluar</button>
                    </form>
                    @endisset
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light text-blue btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal absen -->

    @push('scripts')
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
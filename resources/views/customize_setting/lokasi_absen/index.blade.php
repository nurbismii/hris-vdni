<x-app-layout title="Setting Lokasi">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js"></script>
    @endpush

    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Data Waktu Absen
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal"  onclick="getLocation()" data-bs-target="#addLokasiAbsen">
                            <i class="me-1" data-feather="plus"></i>
                            Tambah
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <x-message />
        <div class="card">
            <div class="card-body" style="overflow-x: auto;">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Divisi</th>
                            <th>Latitude</th>
                            <th>Longtitude</th>
                            <th>Radius</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>{{ $data->divisi->nama_divisi }}</td>
                            <td>{{ $data->lat }}</td>
                            <td>{{ $data->long }}</td>
                            <td>{{ $data->radius }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editWaktuAbsen{{$data->id}}"><i data-feather="edit"></i></a>
                                <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#delWaktuAbsen{{$data->id}}"><i data-feather="trash-2"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addLokasiAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Content</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('store.lokasi') }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        <div class="mb-3">
                            <label class="small mb-1">Divisi</label>
                            <select name="divisi_id" class="form-select" required>
                                <option value="" disabled selected>- Pilih Divisi -</option>
                                @foreach($divisi as $row)
                                <option value="{{ $row->id }}">{{ $row->nama_divisi }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="location" style="width:100%;height:400px;"></div>
                        <div class="mb-3">
                            <label class="small mb-1">Latitude</label>
                            <input type="text" name="lat" id="latSt1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Longtitude</label>
                            <input type="text" name="long" id="lngSt2" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($datas as $data)
    <div class="modal fade" id="editWaktuAbsen{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Form Content</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('update.lokasi', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    @csrf
                    {{ method_field('patch') }}
                    <div class="modal-body">
                        <div id="googleMapUpdate" style="width:100%;height:400px;"></div>
                        <div class="mb-3">
                            <label class="small mb-1">Latitude</label>
                            <input type="text" name="lat" id="latUpd" class="form-control" value="{{ $data->lat }}">
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1">Longtitude</label>
                            <input type="text" name="long" id="lngUpd" class="form-control" value="{{ $data->long }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @foreach($datas as $data)
    <div class="modal fade" id="delWaktuAbsen{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus lokasi</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('delete.lokasi', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        Apa kamu yakin ingin menghapus data ini ({{ $data->divisi->nama_divisi }})?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        <button class="btn btn-primary btn-sm" type="submit">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @push('scripts')
    <script>
        var lat1 = document.getElementById("lat1");
        var lng2 = document.getElementById("lng2");

        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(getPosition);
            } else {
                t.innerHTML = "Geolokasi tidak mendukung browser ini!";
            }
        }

        function getPosition(position) {

            lat1 = position.coords.latitude;
            lng2 = position.coords.longitude;

            document.getElementById("latSt1").value = lat1;
            document.getElementById("lngSt2").value = lng2;

            var propertiPeta = {
                center: new google.maps.LatLng(lat1, lng2),
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var peta = new google.maps.Map(document.getElementById("location"), propertiPeta);
            // membuat Marker
            var marker = new google.maps.Marker({
                position: new google.maps.LatLng(lat1, lng2),
                map: peta
            });
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
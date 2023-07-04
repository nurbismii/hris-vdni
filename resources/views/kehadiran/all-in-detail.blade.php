<x-app-layout title="Absen | Keterangan Absen">
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
                            <div class="page-header-icon"><i data-feather="edit-2"></i></div>
                            Detail Data Absensi
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-lg-12">
                <x-message />
                <div class="card card-collapsable mb-3">
                    <a class="card-header" href="#collapseDetailKaryawan" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">Detail Data Karyawan
                        <div class="card-collapsable-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="collapse" id="collapseDetailKaryawan">
                        <div class="card-body">
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">NIK Karyawan</label>
                                    <input class="form-control" type="text" name="nik_karyawan" value="{{ $data->nik }}" readonly />
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">NIK KTP</label>
                                    <input class="form-control" type="text" name="no_ktp" value="{{ $data->no_ktp }}" readonly />
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Email</label>
                                    <input class="form-control" type="email" value="{{ $data->user->email ?? 'Belum terdaftar sebagai pengguna' }}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1">Agama</label>
                                    <input type="text" name="" class="form-control" value="{{ $data->agama }}" readonly>
                                </div>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Tanggal Lahir</label>
                                    <input class="form-control" type="date" name="tgl_lahir" value="{{ date('Y-m-d', strtotime($data->tgl_lahir)) }}" readonly />
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1">Entry Date</label>
                                    <input class="form-control" type="date" name="entry_date" value="{{ date('Y-m-d', strtotime($data->entry_date)) }}" readonly />
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">No Telp</label>
                                    <input class="form-control" name="no_telp" type="tel" value="{{ $data->no_telp }}" readonly />
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">NPWP</label>
                                    <input class="form-control" type="text" name="npwp" value="{{ $data->npwp }}" readonly />
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">BPSJ Kesehatan</label>
                                    <input class="form-control" name="bpjs_kesehatan" type="text" value="{{ $data->bpjs_kesehatan }}" readonly />
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">BPJS Ketenagakerjaan</label>
                                    <input class="form-control" name="bpjs_tk" type="text" name="bpjs_tk" value="{{ $data->bpjs_tk }}" readonly />
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Area Kerja</label>
                                    <input class="form-control" type="text" name="area_kerja" value="{{ $data->area_kerja }}" readonly />
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Golongan Darah</label>
                                    <input class="form-control" type="text" name="golongan_darah" value="{{ $data->golongan_darah }}" readonly />
                                </div>
                            </div>

                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Posisi</label>
                                    <input class="form-control" type="text" name="posisi" value="{{ $data->posisi }}" readonly />
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <label class="small mb-1">Jabatan</label>
                                    <input class="form-control" type="text" name="jabatan" value="{{ $data->jabatan }}" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body" style="overflow-x:auto;">
                        <table class="table accordion table-condensed table-striped" style="width: 100%;">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Alpa</th>
                                    <th>PL</th>
                                    <th>UL</th>
                                    <th>S</th>
                                    <th>OFF</th>
                                    <th>C</th>
                                    <th>L</th>
                                    <th>Workdays</th>
                                    <th>Total Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data->detailAbsen as $data)
                                <tr class="text-center" data-bs-toggle="collapse" data-bs-target="#accor{{$data->id}}">
                                    <th scope="row">{{ ++$no }}</th>
                                    <th scope="row">{{ $data->nik_karyawan }}</a></td>
                                    <td>{{ getName($data->nik_karyawan) }}</td>
                                    <td>{{ $data->total_alpa }}</td>
                                    <td>{{ $data->paid_leave }}</td>
                                    <td>{{ $data->unpaid_leave }}</td>
                                    <td>{{ $data->total_sakit }}</td>
                                    <td>{{ $data->total_off }}</td>
                                    <td>{{ $data->total_cuti }}</td>
                                    <td>{{ $data->total_libur }}</td>
                                    <td>{{ $data->total_workdays }}</td>
                                    <th scope="row">{{ $data->total_absen }}</th>
                                </tr>
                                <tr class="collapse accordion-collapse" id="accor{{$data->id}}" data-bs-parent=".table">
                                    <td colspan="13">
                                        <table class="table table-striped" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal Mulai Izin</th>
                                                    <th>Tanggal Selesai Izin</th>
                                                    <th>Total Izin</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($keterangan_absen as $row)
                                                @if($data->awal_periode == $row->awal_periode and $data->akhir_periode == $row->akhir_periode)
                                                <tr>
                                                    <td>{{ date('d F Y', strtotime($row->tanggal_mulai_izin)) }}</a></td>
                                                    <td>{{ date('d F Y', strtotime($row->tanggal_selesai_izin)) }}</a></td>
                                                    <td>{{ $row->total_izin }}</td>
                                                    <td>{{ $row->keterangan_izin }}</td>
                                                    <td>{{ ucwords($row->status_izin) }}</td>
                                                    <td>
                                                        <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteKetAbsen{{ $row->id }}"><i data-feather="trash-2"></i></a>
                                                    </td>
                                                </tr>
                                                @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal delete user -->
    @foreach($keterangan_absen as $data)
    <div class="modal fade" id="deleteKetAbsen{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Role</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('destroy.ket', $data->id) }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                    <div class="modal-body">
                        @csrf
                        {{ method_field('delete') }}
                        Yakin ingin menghapus keterangan ini ({{ $data->keterangan_izin }})?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">No</button>
                        <button class="btn btn-primary btn-sm" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

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
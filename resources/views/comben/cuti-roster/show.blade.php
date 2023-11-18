<x-app-layout title="Cuti Roster">
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
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="archive"></i></div>
              Cuti Roster Detail
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-blue" href="/roster">
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
    <div class="row">
      <div class="col-xl-8">
        <div class="card mb-4">
          <div class="card-header">Personal data </div>
          <div class="card-body">
            <form action="{{ route('cutiroster.store') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">Nama</label>
                  <input class="form-control" type="text" name="nama" value="{{$data->karyawan->nama_karyawan}}" readonly />
                </div>
                <div class="col-md-6">
                  <label class="small mb-2">Departemen</label>
                  <input class="form-control" name="departemen" type="text" value="{{$data->karyawan->divisi->departemen->departemen}}" readonly />
                </div>
              </div>
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">NIK</label>
                  <input class="form-control nik_karyawan" name="nik_karyawan" value="{{$data->nik_karyawan}}" readonly />
                </div>
                <div class="col-md-6">
                  <label class="small mb-2">Posisi</label>
                  <input class="form-control" name="posisi" type="text" value="{{$data->karyawan->posisi}}" readonly />
                </div>
              </div>
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">No HP</label>
                  <input class="form-control" name="no_telp" type="number" value="{{$data->karyawan->no_telp}}" readonly />
                </div>
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">Divisi</label>
                  <input class="form-control" name="divisi" type="text" value="{{$data->karyawan->divisi->nama_divisi}}" readonly />
                </div>
              </div>
              <div class="row gx-3 mb-2">
                <div class="col-md-6">
                  <label class="small mb-2">Email</label>
                  <input class="form-control" name="email" type="email" value="{{$data->karyawan->email}}" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-2">Tanggal Pengajuan</label>
                  <input class="form-control date" name="tanggal_pengajuan" type="text" value="{{tgl_indo($data->tanggal_pengajuan)}}" />
                </div>
              </div>
              <hr class="mt-2 mb-2">
              <div class="row">
                <div class="table-responsive col-lg-6">
                  <table class="table table-borderless mb-2">
                    <thead class="border-bottom">
                      <tr class="small text-uppercase text-muted">
                        <th scope="col">Keberangkatan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Cuti roster</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_mulai_cuti" type="text" value="{{tgl_indo($data->tgl_mulai_cuti)}}" />
                        </td>
                      </tr>
                      <tr class=" border-bottom">
                        <td>
                          <div class="fw-bold">Cuti tahunan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_mulai_cuti_tahunan" type="text" value="{{tgl_indo($data->tgl_mulai_cuti_tahunan)}}" />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Off</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_mulai_off" type="text" value="{{tgl_indo($data->tgl_mulai_off)}}" />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Tanggal keberangkatan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tanggal_keberangkatan" type="text" value="{{tgl_indo($data->tgl_keberangkatan)}}" required />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Waktu keberangkatan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control" name="jam_keberangkatan" type="text" maxlength="5" value="{{$data->jam_keberangkatan}}" required />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Dari</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control" name="kota_awal_keberangkatan" value="{{$data->kota_awal_keberangkatan}}" required></input>
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Tujuan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-select" name="kota_tujuan_keberangkatan" value="{{$data->kota_tujuan_keberangkatan}}" required></input>
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Catatan penting</div>
                        </td>
                        <td class="text-end fw-bold">
                          <textarea name="catatan_penting_keberangkatan" class="form-control" value="{{$data->catatan_penting_keberangkatan}}" cols="30" rows="5"></textarea>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="table-responsive col-lg-6">
                  <table class="table table-borderless mb-0">
                    <thead class="border-bottom">
                      <tr class="small text-uppercase text-muted">
                        <th scope="col">Kepulangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Cuti roster berakhir</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_mulai_cuti_berakhir" type="text" value="{{tgl_indo($data->tgl_mulai_cuti_berakhir)}}" required />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Cuti tahunan berakhir</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_mulai_cuti_tahunan_berakhir" type="text" value="{{tgl_indo($data->tgl_mulai_cuti_tahunan_berakhir)}}" />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Off berakhir</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_mulai_off_berakhir" type="text" value="{{tgl_indo($data->tgl_mulai_off_berakhir)}}" />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Tanggal kepulangan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control date" name="tgl_kepulangan" type="text" value="{{tgl_indo($data->tgl_kepulangan)}}" required />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Waktu kepulangan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control" name="jam_kepulangan" type="text" maxlength="5" value="{{$data->jam_kepulangan}}" required />
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Dari</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control" name="kota_awal_kepulangan" value="{{$data->kota_awal_kepulangan}}" required></input>
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Tujuan</div>
                        </td>
                        <td class="text-end fw-bold">
                          <input class="form-control" name="kota_tujuan_kepulangan" value="{{$data->kota_tujuan_kepulangan}}" required></input>
                        </td>
                      </tr>
                      <tr class="border-bottom">
                        <td>
                          <div class="fw-bold">Catatan penting</div>
                        </td>
                        <td class="text-end fw-bold">
                          <textarea name="catatan_penting_kepulangan" class="form-control" value="{{$data->catatan_penting_kepulangan}}" cols="30" rows="5"></textarea>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="mb-3">
                Berkas : <a href="{{route('cutiroster.download', $data->id)}}" target="_blank" rel="noopener noreferrer">{{ $data->file }}</a>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Status Pengajuan</div>
          <div class="card-body">
            <form action="{{ route('cutiroster.update', $data->id) }}" method="post">
              @csrf
              <label for="" class="mb-2">Status pengajuan</label>
              <select name="status_pengajuan" class="form-select">
                <option value="{{$data->status_pengajuan}}">{{ ucfirst($data->status_pengajuan)}}</option>
                @if($data->status_pengajuan != 'diterima')
                <option value="diterima">Diterima</option>
                @endif
                @if($data->status_pengajuan != 'ditolak')
                <option value="ditolak">Ditolak</option>
                @endif
              </select>
              <hr class="my-4" />
              <div class="d-grid">
                <button class="btn btn-primary" type="submit">Perbarui status</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card mb-4 mt-3 mb-xl-0">
          <div class="card-header">Upload tiket</div>
          <div class="card-body">
            <form action="{{ route('cutiroster.upload.tiket', $data->id) }}" enctype="multipart/form-data" method="post">
              @csrf
              <label for="" class="mb-2">Pilih file</label>
              <input type="file" name="tiket_pesawat" class="form-control">
              <hr class="my-4" />
              <div class="mb-3">
                Tiket : 
                @if($data->tiket_pesawat != null)
                <a href="{{route('cutiroster.download.tiket', $data->id)}}" target="_blank" rel="noopener noreferrer">{{ substr($data->tiket_pesawat, 0, 35) }}...</a>
                @else
                  Tiket belum tersedia
                @endif
              </div>
              <hr class="my-4" />
              <div class="d-grid">
                <button class="btn btn-primary" type="submit">Kirim</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    @push('scripts')
    <x-toastr />
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
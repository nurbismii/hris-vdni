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
              Cuti roster detail
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-blue" href="/ess/lembur">
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
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body" style="overflow-x:auto;">
            <h3 class="text-primary text-center mb-3">Formulir Surat Perintah Lembur</h3>
            <div class="table-responsive">
              <table class="table table-bordered mb-2">
                <tbody>
                  <tr>
                    <td>Nomor Induk Karyawan</td>
                    <td>{{$data->nik_karyawan}}</td>
                    <td>Tanggal Pengajuan</td>
                    <td>{{tgl_indo($data->tanggal_pengajuan)}}</td>
                  </tr>
                  <tr>
                    <td>Nama Karyawan</td>
                    <td>{{ $data->nama_karyawan }}</td>
                    <td>Email</td>
                    <td>{{ $data->email ?? '' }}</td>
                  </tr>
                  <tr>
                    <td>Departemen</td>
                    <td>{{$data->karyawan->divisi->nama_divisi}}</td>
                    <td>Posisi</td>
                    <td>{{$data->karyawan->posisi}}</td>
                  </tr>
                  <tr>
                    <td>Mulai Lembur</td>
                    <td>{{$data->mulai_lembur}}</td>
                    <td>Berakhir Lembur</td>
                    <td>{{$data->berakhir_lembur}}</td>
                  </tr>
                  <tr>
                    <td>Tipe Lembur</td>
                    <td>{{ $data->tipe_lembur == '1' ? 'Tanggal Merah' : ($data->tipe_lembur == '2' ? 'OFF' : ($data->tipe_lembur == '3' ? 'Kelebihan Jam' : '')) }}</td>
                    <td>Total</td>
                    <td>{{$data->selisih_lembur}} Jam</td>
                  </tr>
                  <tr>
                    <td>Keterangan</td>
                    <td colspan="3">{{ $data->keterangan }}</td>
                  </tr>
                </tbody>
              </table>

              <table class="table table-bordered mb-0">
                <thead class="border-bottom">
                  <tr class="small text-uppercase text-muted">
                    <th width="50%" class="text-center">Persetujuan Karyawan</th>
                    <th width="50%" class="text-center">Persetujuan HOD</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      @if(strtoupper($data->persetujuan_karyawan) == "DITERIMA")
                      <div class="text-center">
                        <img src="{{ asset('assets/img/backgrounds/logo-disetujui.png') }}" style="height: 80px; width:120px" class="text-center">
                      </div>
                      @endif
                    </td>
                    <td>
                      @if(strtoupper($data->persetujuan_hod) == "DITERIMA")
                      <div class="text-center">
                        <img src="{{ asset('assets/img/backgrounds/logo-disetujui.png') }}" style="height: 80px; width:120px" class="text-center">
                      </div>
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Perbarui status</div>
          <div class="card-body">
            <form action="{{ route('update.lembur', $data->id) }}" method="post" enctype="multipart/form-data">
              @csrf
              {{ method_field('patch') }}
              @if($data->persetujuan_karyawan != 'Diterima')
              <label for="persetujuan_karyawan" class="mb-2">Pilih status</label>
              <select name="persetujuan_karyawan" class="form-select">
                <option value="" disabled selected>Pilih status :</option>
                <option value="Diterima">Diterima</option>
                <option value="Menunggu">Menunggu</option>
                <option value="Ditolak">Ditolak</option>
              </select>
              <hr class="my-4" />
              <div class="d-grid">
                <button class="btn btn-primary" type="submit">Perbarui status</button>
              </div>
              @endif
              <div class="fw-bold text-uppercase">pengajuan telah diterima</div>
            </form>
          </div>
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
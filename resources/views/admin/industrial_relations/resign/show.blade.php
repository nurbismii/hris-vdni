<x-app-layout title="Detail karyawan resign">

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
              <div class="page-header-icon"><i data-feather="credit-card"></i></div>
              Detail Karyawan Resign
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-blue" href="#" target="_blank">
              <i class="me-1" data-feather="printer"></i>
              Print
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main page content-->
  <div class="container-xl px-4 mt-4">
    <!-- Invoice-->
    <div class="card invoice">
      <div class="card-body p-2 p-md-4">
        <div class="text-center lh-1 mb-2">
          <h4 class="fw-bold">PT VDNI</h4> <br>
          <img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 50px;" alt=""><br> <br>
          <span class="fw-normal mb-2"> PENGUNDURAN DIRI </span> <br> <br>
          <span class="fw-normal"> Periode ({{ date('F Y', strtotime($data->periode_awal)) }} - {{ date('F Y', strtotime($data->periode_akhir)) }})</span>
        </div>
        <div class="table-responsive">
          <table class="table table-hover mb-0">
            <tbody>
              <tr>
                <th scope="row">NIK Pekerja</th>
                <td>{{ $data->nik_karyawan }}</td>
                <td>No KTP</td>
                <td>{{ $data->no_ktp }}</td>
              </tr>
              <tr>
                <th scope="row">Nama Karyawan</th>
                <td>{{ $data->nama_karyawan }}</td>
                <td>Status Karyawan</td>
                <td>{{ $data->status_karyawan }}</td>
              </tr>
              <tr>
                <th scope="row">Departement</th>
                <td>{{ $data->departemen }}</td>
                <td>Divisi</td>
                <td>{{ $data->nama_divisi }}</td>
              </tr>
              <tr>
                <th scope="row">Position</th>
                <td>{{ $data->posisi }}</td>
                <td>Tanggal masuk</td>
                <td>{{ tgl_indo($data->entry_date) }}</td>
              </tr>
              <tr>
                <th scope="row">Tempat dan tanggal lahir</th>
                <td colspan="4">{{ tgl_indo($data->tgl_lahir) }}</td>
              </tr>
              <tr>
                <th scope="row">No telephone</th>
                <td colspan="4">{{ $data->no_telp }}</td>
              </tr>
              <tr>
                <th scope="row">Alamat KTP</th>
                <td colspan="4">{{ $data->alamat_ktp }}</td>
              </tr>
              <tr>
                <th class="align-middle" rowspan="4" scope="row">Pengunduran diri</th>
              </tr>
              <tr>
                <td>Pengunduran diri paksa</td>
                <td class="text-center" colspan="4">
                  @if($data->tipe == 'PAKSA')
                  &radic;
                  @endif
                </td>
              </tr>
              <tr>
                <td>Pemutusan kontrak</td>
                <td class="text-center" colspan="4">
                  @if($data->tipe == 'PHK' || $data->tipe == 'PUTUS KONTRAK' || $data->tipe == 'KABUR')
                  &radic;
                  @endif
                </td>
              </tr>
              <tr>
                <td>Mengundurkan diri sukarela</td>
                <td class="text-center" colspan="4">
                  @if($data->tipe == 'BAIK' || $data->tipe == 'PB RESIGN' || $data->tipe == 'PASAL (50)')
                  &radic;
                  @endif
                </td>
              </tr>
              <tr>
                <th scope="row">Alasan pengunduran diri</th>
                <td colspan="4">{{ $data->alasan_keluar }}</td>
              </tr>
              <tr>
                <th scope="row">Tanggal permintaan</th>
                <td>{{ tgl_indo($data->tanggal_pengajuan) }}</td>
                <td>Tanggal keluar</td>
                <td colspan="2">{{ tgl_indo($data->tanggal_keluar) }}</td>
              </tr>
              <tr>
                <th>HOD</th>
                <td class="text-center" colspan="4">&radic;</td>
              </tr>
              <tr>
                <th>Diketahui HRD</th>
                <td class="text-center" colspan="4">&radic;</td>
              </tr>
              <tr>
                <th>Penanggung jawab APD</th>
                <td class="text-center" colspan="4">&radic;</td>
              </tr>
              <tr>
                <th scope="row">Statistik absen</th>
                <td>Absen sebelumnya</td>
                <td></td>
                <td>Asben bulan ini</td>
                <td></td>
              </tr>
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
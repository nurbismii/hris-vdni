<x-app-layout title="Pengingat">
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
    <div class="container-fluid px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="user"></i></div>
              Pengajuan cuti roster & insentif
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
      <div class="col-lg-12 mb-2">
        <form action="/roster/daftar-pengingat" method="get">
          @csrf
          <div class="card">
            <div class="card-body" style="overflow-x: auto;">
              <select name="status_pengajuan" id="" class="form-select">
                <option value="" disabled selected>Pilih status pengajuan :</option>
                <option value="Belum Pengajuan">Belum pengajuan</option>
                <option value="Jatuh Tempo">Jatuh tempo</option>
              </select>
              <div class="mt-2">
                <button class="btn btn-sm btn-light text-primary" type="submit">
                  <i class="me-1" data-feather="search"></i>
                  Filter
                </button>
                <a class="btn btn-sm btn-light text-primary" href="/roster/daftar-pengingat">
                  <i class="me-1" data-feather="trash"></i>
                  Bersihkan
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body" style="overflow-x: auto;">
            <table id="datatablesSimple" class="table table-hover">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Tanggal pengajuan</th>
                  <th>Tipe pilihan</th>
                  <th>Form</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($datas as $data)
                <tr>
                  <td>{{ ++$no }}</td>
                  <td>{{ $data->nik_karyawan }}</td>
                  <td>{{ getName($data->nik_karyawan) }}</td>
                  <td>{{ $data->tanggal_pengajuan }}</td>
                  <td>
                    @if($data->periode_kerja->tipe_rencana == '1')
                    CUTI
                    @else
                    BEKERJA
                    @endif
                  </td>
                  <td>
                    <a href="{{route('admindept.print', $data->id)}}" target="_blank" class="btn btn-sm btn-secondary"><i data-feather="download"></i></a>
                  </td>
                  <td>
                    <a href="{{route('admindept.print', $data->id)}}" target="_blank" class="btn btn-sm btn-primary">Detail</a>
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
  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/litepicker.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  @endpush
</x-app-layout>
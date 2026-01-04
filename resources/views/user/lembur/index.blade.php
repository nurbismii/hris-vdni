<x-app-layout title="Kelola Lembur">
  @push('styles')
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
  <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/datetime/1.4.0/css/dataTables.dateTime.min.css" rel="stylesheet" />

  <!-- Toastr -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="file-text"></i></div>
              Data SPL
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
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body" style="overflow-x: auto;">
            <table id="datatablesSimple" class="table table-hover">
              <div class="row gx-3 mb-3">
                <div class="col-md-4 mb-3">
                  <select name="status_hrd" class="form-select" id="tipe_lembur">
                    <option value="" selected>- Pilih Tipe Lembur -</option>
                    <option value="1">Tanggal Merah</option>
                    <option value="2">OFF</option>
                    <option value="3">Kelebihan Jam</option>
                  </select>
                </div>
              </div>
              <thead>
                <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Mulai</th>
                  <th>Berakhir</th>
                  <th>Total</th>
                  <th>Tipe Lembur</th>
                  <th>Status</th>
                  <th>HOD</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($data as $d)
                <tr>
                  <td>{{$d->nik_karyawan}}</td>
                  <td>{{$d->nama_karyawan}}</td>
                  <td>{{$d->mulai_lembur}}</td>
                  <td>{{$d->berakhir_lembur}}</td>
                  <td>{{$d->selisih_lembur}}</td>
                  <td>{{$d->tipe_lembur == '1' ? 'Tanggal Merah' : ($d->tipe_lembur == '2' ? 'OFF' : ($d->tipe_lembur == '3' ? 'Kelebihan Jam' : ''))}}</td>
                  <td>
                    @if($d->persetujuan_karyawan == 'Diterima')
                    <span class="badge bg-success">{{$d->persetujuan_karyawan}}</span>
                    @else
                    <span class="badge bg-primary">{{$d->persetujuan_karyawan}}</span>
                    @endif
                  </td>
                  <td>
                    @if($d->persetujuan_hod == 'Diterima')
                    <span class="badge bg-success">{{$d->persetujuan_hod}}</span>
                    @else
                    <span class="badge bg-primary">{{$d->persetujuan_hod}}</span>
                    @endif
                  </td>
                  <td><a class="btn btn-primary btn-sm mb-1" href="{{ route('show.lembur', $d->id)}}"><i>Detail</i></a></td>
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
  <script src="{{ asset('js/scripts.js') }}"></script>
  <script src="{{ asset('js/chart.min.js') }}" crossorigin="anonymous"></script>
  <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
  <script src="{{ asset('js/litepicker.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
  <script src="https://cdn.datatables.net/datetime/1.4.0/js/dataTables.dateTime.min.js"></script>
  @endpush
</x-app-layout>
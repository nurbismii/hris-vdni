<x-app-layout title="Cuti Roster">
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
  <style>
    td {
      text-transform: uppercase
    }
  </style>
  @endpush
  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-s4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="users"></i></div>
              Data Pengajuan Cuti Roster
            </h1>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-fluid px-4">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body" style="overflow-x:auto;">
            <table id="datatablesSimple" class="table table-hover" style="width: 100%;">
              <thead>
                <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Tanggal pengajuan</th>
                  <th>Tipe</th>
                  <th>HOD</th>
                  <th>HR</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($cuti as $row)
                <tr>
                  <td>{{ $row->nik_karyawan }}</td>
                  <td>{{ getName($row->nik_karyawan) }}</td>
                  <td>{{ tgl_indo($row->tanggal_pengajuan) }}</td>
                  <td>{{ $row->tipe_rencana == '1' ? 'Cuti' : 'Bekerja' }}</td>
                  <td>
                    @if($row->status_pengajuan == 'diterima')
                    <span class="badge bg-success fw-bold">{{ ucfirst($row->status_pengajuan) }}</span>
                    @elseif($row->status_pengajuan == 'ditolak')
                    <span class="badge bg-danger">{{ ucfirst($row->status_pengajuan) }}</span>
                    @else
                    <span class="badge bg-primary">{{ ucfirst($row->status_pengajuan) }}</span>
                    @endif
                  </td>
                  <td>
                    @if($row->status_pengajuan_hrd == 'diterima')
                    <span class="badge bg-success fw-bold">{{ ucfirst($row->status_pengajuan_hrd) }}</span>
                    @elseif($row->status_pengajuan_hrd == 'ditolak')
                    <span class="badge bg-danger">{{ ucfirst($row->status_pengajuan_hrd) }}</span>
                    @else
                    <span class="badge bg-primary">{{ ucfirst($row->status_pengajuan_hrd) }}</span>
                    @endif
                  </td>
                  <td>
                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" id="dropdownFadeIn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i data-feather="more-vertical"></i></button>
                    <div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFadeIn">
                      <a class="dropdown-item" href="{{ route('show.pengajuan.roster', $row->id) }}">Detail</a>
                      <!-- <a class="dropdown-item" href="#!">Edit</a> -->
                    </div>
                    <button class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#modalHapusPermohonan"><i data-feather="trash-2"></i></button>
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

  <!-- Modal -->
  @foreach($cuti as $row)
  <div class="modal fade" id="modalHapusPermohonan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('destroy.pengajuan.roster', $row->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{ method_field('delete') }}
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Hapus permohonan</h5>
            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">Apa kamu yakin ingin menghapus permohonan ini ?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tidak</button>
            <button class="btn btn-primary" type="submit">Hapus</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  @endforeach

  @push('scripts')
  <x-toastr />

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
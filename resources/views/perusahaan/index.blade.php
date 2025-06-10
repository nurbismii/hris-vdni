<x-app-layout title="Departemen">
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
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="codepen"></i></div>
              Data perusahaan
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addCompany">
              <i class="me-1" data-feather="plus"></i>
              Perusahaan
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-fluid px-4">
    <div class="card">
      <div class="card-body" style="overflow-x: auto;">
        <table id="datatablesSimple">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode</th>
              <th>Nama Perusahaan</th>
              <th>Departemen</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $row)
            <tr>
              <td>{{ ++$no }}</td>
              <td>{{ $row->kode_perusahaan }}</td>
              <td>{{ $row->nama_perusahaan }}</td>
              <td>
                <a class="btn btn-sm btn-primary" href="{{ route('perusahaan.show', $row->id) }}"> Daftar departemen</a>
              </td>
              <td>
                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editCompany{{ $row->id }}"><i data-feather="edit"></i></a>
                <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#hapusCompany{{ $row->id }}"><i data-feather="trash-2"></i></a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addCompany" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Perusahaan</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('perusahaan.store') }}" method="POST" class="nav flex-column" id="stickyNav">
          <div class="modal-body">
            @csrf
            <div class="mb-3">
              <label class="small mb-1">Kode perusahaan</label>
              <input type="text" class="form-control" name="kode_perusahaan">
            </div>
            <div class="mb-3">
              <label class="small mb-1">Nama perusahaan</label>
              <input type="text" class="form-control" name="nama_perusahaan">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
            <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @foreach($data as $row)
  <div class="modal fade" id="editCompany{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Perusahaan</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('perusahaan.update', $row->id) }}" method="POST" class="nav flex-column" id="stickyNav">
          <div class="modal-body">
            @csrf
            {{method_field('patch')}}
            <div class="mb-3">
              <label class="small mb-1">Kode perusahaan</label>
              <input type="text" class="form-control" name="departemen" value="{{ $row->kode_perusahaan }}">
            </div>
            <div class="mb-3">
              <label class="small mb-1">Nama perusahaan</label>
              <input type="text" class="form-control" name="kepala_dept" value="{{ $row->nama_perusahaan }}">
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
            <button class="btn btn-primary btn-sm" type="submit">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach

  @foreach($data as $row)
  <div class="modal fade" id="hapusCompany{{$row->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Perusahaan</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('perusahaan.update', $row->id) }}" method="POST" class="nav flex-column" id="stickyNav">
          <div class="modal-body">
            @csrf
            {{method_field('patch')}}
            Apa kamu yakin ingin menghapus data ini ? Semua data departemen akan terhapus!
          </div>
          <div class="modal-footer">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Tidak</button>
            <button class="btn btn-primary btn-sm" type="submit">Hapus</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach

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
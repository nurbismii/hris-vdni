<x-app-layout title="Profile">

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
              <div class="page-header-icon"><i data-feather="user"></i></div>
              Pengaturan Akun - Profil
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-blue" href="/">
              <i class="me-1" data-feather="x"></i>
              Tutup
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <div class="container-xl px-4 mt-4">
    <x-nav-account />
    <hr class="mt-0 mb-4" />
    <div class="row">
      <x-message />
      <div class="col-xl-4">
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Foto Profil</div>
          <div class="card-body text-center">
            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" alt="" />
            <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 5MB</div>
            <button class="btn btn-primary btn-sm" type="button">Unggah foto profil</button>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card mb-4">
          <div class="card-header">Data Pribadi
            <a href="" title="Pengaturan Profil" class="btn lift btn-sm float-end"><i data-feather="settings"></i></a>
          </div>
          <div class="card-body">
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Karyawan (NIK)</label>
                <input class="form-control" type="text" value="{{ Auth::user()->nik_karyawan }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Posisi</label>
                <input class="form-control" type="text" value="{{ Auth::user()->job->permission_role ?? 'User' }}" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Name</label>
                <input class="form-control" name="name" type="text" value="{{ Auth::user()->employee->nama_karyawan }}" />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Email address</label>
                <input class="form-control" name="email" type="email" value="{{ Auth::user()->email }}" />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Departemen</label>
                <input class="form-control" value="" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Divisi</label>
                <input class="form-control" value="" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Durasi Kontrak</label>
                <input class="form-control" value="" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Kontrak Berakhir</label>
                <input class="form-control" value="" disabled />
              </div>
            </div>
            <div class="col-lg-6 mb-3">
              <tbody>
                @if(strtoupper(Auth::user()->status == 'aktif'))
                <tr>
                  <td><label class="small mb-1">Status</label></td>
                  <td>:</td>
                  <td><span class="badge bg-success">Aktif</span></td>
                </tr>
                @else
                <tr>
                  <td><label class="small mb-1">Status</label></td>
                  <td>:</td>
                  <td><span class="badge bg-danger">Tidak Aktif</span></td>
                </tr>
                @endif
              </tbody>
            </div>
          </div>
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
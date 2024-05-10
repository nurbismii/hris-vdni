<x-app-layout title="Profile">

  @push('styles')
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
  <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Toastr  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

  <style>
    a {
      color: #79818d;
      text-decoration: none;
    }
  </style>
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="user"></i></div>
              Akun
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
      <div class="col-xl-4">
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Foto profil</div>
          <div class="card-body text-center">
            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" alt="" />
            <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 10MB</div>
            <button class="btn btn-primary btn-sm" type="button">Upload</button>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card mb-4">
          <div class="card-header">Data personal
            <a href="" title="Pengaturan Profil" class="btn lift btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#set-profil"><i data-feather="settings"></i></a>
          </div>
          <div class="card-body">
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Nomor induk karywan (NIK)</label>
                <input class="form-control" type="text" value="{{ Auth::user()->nik_karyawan }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Posisi</label>
                <input class="form-control" type="text" value="{{ Auth::user()->job->permission_role ?? 'User' }}" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Nama</label>
                <input class="form-control" name="name" type="text" value="{{ Auth::user()->employee->nama_karyawan }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Email</label>
                <input class="form-control" name="email" type="email" value="{{ Auth::user()->email }}" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Departemen</label>
                <input class="form-control" value="{{ $divisi->departemen->departemen ?? '-' }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Divisi</label>
                <input class="form-control" value="{{ $divisi->nama_divisi ?? '' }}" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Jabatan</label>
                <input class="form-control" value="{{ Auth::user()->employee->jabatan }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Posisi</label>
                <input class="form-control" value="{{ Auth::user()->employee->posisi }}" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Status</label>
                <input class="form-control" value="{{ Auth::user()->employee->status_karyawan }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Durasi kontrak</label>
                <input class="form-control" value="{{ Auth::user()->contract->lama_kontrak ?? '-' }}" disabled />
              </div>
            </div>
            <div class="row gx-3 mb-3">
              <div class="col-md-6">
                <label class="small mb-1">Mulai kontrak</label>
                <input class="form-control" value="{{ Auth::user()->contract->tanggal_mulai_kontrak ?? '-' }}" disabled />
              </div>
              <div class="col-md-6">
                <label class="small mb-1">Berakhir kontrak</label>
                <input class="form-control" value="{{ Auth::user()->contract->tanggal_berakhir_kontrak ?? '-' }}" disabled />
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
                  <td><span class="badge bg-danger">Tidak aktif</span></td>
                </tr>
                @endif
              </tbody>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="set-profil" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pengaturan akun</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('update.akun', Auth::user()->nik_karyawan) }}" method="POST" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
          <div class="modal-body">
            @csrf
            {{ method_field('patch') }}
            <div class="mb-3">
              <label class="small mb-1">Email</label>
              <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
            </div>
            <div class="mb-3">
              <div class="form-group">
                <label class="small mb-1">Kata sandi</label>
                <div class="input-group input-group-joined" id="show_hide_password">
                  <input class="form-control pe-0" name="password" type="password" required>
                  <span class="input-group-text" style="background-color: #F5F5F5;">
                    <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                  </span>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <div class="form-group">
                <label class="small mb-1">Konfirmasi kata sandi</label>
                <div class="input-group input-group-joined" id="show_hide_password_2">
                  <input class="form-control pe-0" name="password_confirm" type="password" required>
                  <span class="input-group-text" style="background-color: #F5F5F5;">
                    <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                  </span>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Tidak</button>
            <button class="btn btn-primary" type="submit">Perbarui</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    $(document).ready(function() {
      $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
          $('#show_hide_password input').attr('type', 'password');
          $('#show_hide_password i').addClass("fa-eye-slash");
          $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
          $('#show_hide_password input').attr('type', 'text');
          $('#show_hide_password i').removeClass("fa-eye-slash");
          $('#show_hide_password i').addClass("fa-eye");
        }
      });

      $("#show_hide_password_2 a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password_2 input').attr("type") == "text") {
          $('#show_hide_password_2 input').attr('type', 'password');
          $('#show_hide_password_2 i').addClass("fa-eye-slash");
          $('#show_hide_password_2 i').removeClass("fa-eye");
        } else if ($('#show_hide_password_2 input').attr("type") == "password") {
          $('#show_hide_password_2 input').attr('type', 'text');
          $('#show_hide_password_2 i').removeClass("fa-eye-slash");
          $('#show_hide_password_2 i').addClass("fa-eye");
        }
      });
    });
  </script>
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
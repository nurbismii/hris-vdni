<x-app-layout title="Employee">
  @push('styles')
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
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
              Account Settings - Profile
            </h1>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-4">
    <hr class="mt-0 mb-4" />
    <div class="row">
      <div class="col-xl-4">
        <!-- Profile picture card-->
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Foto Profile</div>
          <div class="card-body text-center">
            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/illustrations/profiles/profile-4.png')}}" alt="" />
            <div class="small font-italic text-muted mb-2"></div>
            <div class="small font-italic text-muted mb-2">Tanggal Masuk {{ $data->entry_date }}</div>
            <div class="small font-italic text-muted mb-2">
              @if($data->vaccine == '3')
              <span class="badge bg-success"> Booster </span>
              @elseif($data->vaccine == '2')
              <span class="badge bg-warning"> Vaksin ke-2 (Wajib Antigen) </span>
              @else
              <span class="badge bg-danger">Swab / Antigen (Wajib)</span>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <!-- Account details card-->
        <div class="card mb-4">
          <div class="card-header">Detail akun</div>
          <div class="card-body">
            <form>
              <div class="mb-3">
                <label class="small mb-1">Nama</label>
                <input class="form-control" type="text" value="{{ $data->name }}" readonly />
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">NIK</label>
                  <input class="form-control" type="text" value="{{ $data->nik }}" readonly />
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">Perusahaan</label>
                  <input class="form-control" type="text" value="{{ $data->company_name }}" readonly />
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">No KTP</label>
                  <input class="form-control" type="text" value="{{ $data->no_ktp }}" readonly />
                </div>
                <!-- Form Group (location)-->
                <div class="col-md-6">
                  <label class="small mb-1">Tanggal Lahir</label>
                  <input class="form-control" type="text" value="{{ date('d F Y', strtotime($data->date_of_birth)) }}" readonly />
                </div>
              </div>
              <!-- Form Group (email address)-->
              <div class="mb-3">
                <label class="small mb-1">Email address</label>
                <input class="form-control" type="email" value="{{ $data->user->email ?? '-' }}" readonly />
              </div>
              <!-- Form Row-->
              <div class="row gx-3 mb-3">
                <!-- Form Group (phone number)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="inputPhone">BPJS Kesehatan</label>
                  <input class="form-control" type="tel" value="{{ $data->bpjs_ket ?? '-' }}" readonly />
                </div>
                <!-- Form Group (birthday)-->
                <div class="col-md-6">
                  <label class="small mb-1" for="inputBirthday">BPJS Ketenagakerjaan</label>
                  <input class="form-control" type="text" name="birthday" value="{{ $data->bpjs_tk ?? '-' }}" readonly />
                </div>
              </div>
              <!-- Save changes button-->
              <a href="/employees" class="btn btn-primary btn-sm" type="button">Kembali</a>
            </form>
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
  @endpush
</x-app-layout>
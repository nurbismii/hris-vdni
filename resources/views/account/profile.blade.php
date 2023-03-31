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
              Account Settings - Profile
            </h1>
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
          <div class="card-header">Profile Picture</div>
          <div class="card-body text-center">
            <img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/illustrations/profiles/profile-1.png')}}" alt="" />
            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
            <button class="btn btn-primary" type="button">Upload new image</button>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card mb-4">
          <div class="card-header">Account Details</div>
          <div class="card-body">
            <form>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">Name</label>
                  <input class="form-control" id="inputFirstName" type="text" value="{{ Auth::user()->name }}" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">NIK</label>
                  <input class="form-control" id="inputLastName" type="text" value="{{ Auth::user()->employee_id }}" disabled/>
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">Job</label>
                  <input class="form-control" type="text" value="{{ Auth::user()->job->permission_role ?? 'Not registered' }}" disabled/>
                </div>
                <div class="col-md-6">
                  <label class="small mb-1" for="inputLocation">Status</label>
                  <input class="form-control" id="inputLocation" type="text" value="{{ Auth::user()->status == '1' ? 'Active' : 'Not Active' }}" disabled/>
                </div>
              </div>
              <div class="mb-3">
                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                <input class="form-control" id="inputEmailAddress" type="email" value="{{ Auth::user()->email }}" />
              </div>
              <button class="btn btn-primary" type="button">Save changes</button>
            </form>
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
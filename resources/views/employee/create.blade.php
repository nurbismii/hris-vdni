<x-app-layout title="Create-Employee">
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
              <div class="page-header-icon"><i data-feather="user-plus"></i></div>
              Add Employee
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-primary" href="/employees">
              <i class="me-1" data-feather="arrow-left"></i>
              Back to Employee List
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-4">
    <div class="row">
      <div class="col-xl-12">
        <div class="card mb-4">
          <div class="card-header">Add Employee</div>
          <div class="card-body">
            <form action="" enctype="application/x-www-form-urlencoded" method="POST">
              @csrf
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">Staff Id / NIK</label>
                  <input class="form-control" name="nik" type="text" placeholder="Enter your staff id / NIK" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">Resident Card Number</label>
                  <input class="form-control" name="no_ktp" type="text" placeholder="Enter your KTP" />
                </div>
              </div>
              <div class="mb-3">
                <label class="small mb-1">Full Name</label>
                <input class="form-control" name="name" type="text" placeholder="Enter your full name" />
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">Company Name</label>
                  <input class="form-control" name="company_name" type="text" placeholder="Enter your company name" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">Date of Birthday</label>
                  <input class="form-control" name="date" type="date" />
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">NPWP</label>
                  <input class="form-control" name="npwp" type="text" placeholder="Enter your NPWP" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">BPJS Kesehatan</label>
                  <input class="form-control" name="bpjs" type="text" placeholder="Enter your BPJS" />
                </div>
              </div>
              <div class="row gx-3 mb-3">
                <div class="col-md-6">
                  <label class="small mb-1">BPJS Ketenagakerjaan</label>
                  <input class="form-control" name="bpjs_tk" type="text" placeholder="Enter your BPJS TK" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-1">Vaccine Level</label>
                  <select name="vaccine" class="form-control">
                    <option value="" selected disabled> - Select your level - </option>
                    <option value="1">Vaccine 1</option>
                    <option value="2">Vaccine 2</option>
                    <option value="3">Booster 1</option>
                    <option value="4">Booster 2</option>
                  </select>
                </div>
              </div>
              <!-- Submit button-->
              <button class="btn btn-primary" type="button">Add Employee</button>
            </form>
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
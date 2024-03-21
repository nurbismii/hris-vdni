<x-app-layout title="Impor Resign">
  @push('styles')
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
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

  <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
      <div class="page-header-content pt-4">
        <div class="row align-items-center justify-content-between">
          <div class="col-auto mt-4">
            <h3 class="page-header-title">
              <div class="page-header-icon"><i data-feather="file"></i></div>
              Bulk
            </h3>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-n10">
    <div class="row">
      <div class="col-lg-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <form action="{{ route('resign.import.store') }}" enctype="multipart/form-data" method="post">
                @csrf
                <label class="form-label">Bulk laporan data resign :</label>
                <input class="form-control" type="file" name="file" id="formFile" required>
                <button type="submit" class="btn btn-primary btn-sm mt-2 float-end">Kirim</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-3">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <form action="{{ route('resign.import.update') }}" enctype="multipart/form-data" method="post">
                @csrf
                <label class="form-label">Bulk update data resign :</label>
                <input class="form-control" type="file" name="file" id="formFile" required>
                <button type="submit" class="btn btn-primary btn-sm mt-2 float-end">Kirim</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <form action="#" enctype="multipart/form-data" method="post">
                @csrf
                <label class="form-label">Bulk hapus data resign :</label>
                <input class="form-control" type="file" name="file" id="formFile" required>
                <button type="submit" class="btn btn-danger btn-sm mt-2 float-end">Kirim</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <x-toastr />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
  <script src="{{ asset('js/litepicker.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  @endpush
</x-app-layout>
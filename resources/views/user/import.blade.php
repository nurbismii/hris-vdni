<x-app-layout title="Import Pengguna">
  @push('styles')
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
  <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  @endpush

  <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
      <div class="page-header-content pt-4">
        <div class="row align-items-center justify-content-between">
          <div class="col-auto mt-4">
            <h3 class="page-header-title">
              <div class="page-header-icon"><i data-feather="file"></i></div>
              Impor Pengguna
            </h3>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-n10">
    <x-message />
    <div class="card">
      <div class="card-header">Impor Excel
        <a class="btn btn-sm btn-light text-primary float-end" href="/users">
          <i class="me-1" data-feather="arrow-left"></i>
          Kembali
        </a>
      </div>
      <div class="card-body">
        <a class="btn btn-indigo  btn-sm lift mb-3" href="{{ route('download.exampleUser') }}">
          <i>Unduh Template</i>
        </a>
        <p class="col-12">
          Pertama silahkan unduh template / format file yang disediakan dan jangan mengubah isi filenya.
        </p>
        <p class="col-12 text-justify">
          Kolom yang wajib di isi (Name, email, password, level, status and employee NIK.)
        </p>
        <form action="{{ route('import.user') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row gx-3 mb-3">
            <div class="mb-3 col-4">
              <input class="form-control" name="file" type="file" id="formFile" required>
            </div>
            <div class="mb-3 col-3">
              <button class="btn btn-primary" type="submit">Kirim berkas</button>
            </div>
          </div>
        </form>
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
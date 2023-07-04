<x-app-layout title="Import Payslip">
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
              Import Payslip
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
      <div class="card-header">Import file excel</div>
      <div class="card-body">
        <!-- Button with lift -->
        <a class="btn btn-indigo  btn-sm lift mb-3" href="{{ route('export.salary') }}">
          <i>Download template file</i>
        </a>
        <p class="col-12">
          Baris pertama dalam file sampel yang diunduh harus tetap apa adanya. Harap jangan mengubah urutan kolom dalam file.
        </p>
        <p class="col-12 text-justify">
          Urutan kolom yang benar adalah (NIK, KTP, Departemen, Divisi, Jabatan, Durasi SP dan lain-lain)
        </p>
        <!-- Fade In Animation -->
        <div class="timeline timeline-sm">
          <div class="timeline-item">
            <div class="timeline-item-marker">
              <div class="timeline-item-marker-text">Pertama</div>
              <div class="timeline-item-marker-indicator"><i data-feather="check"></i></div>
            </div>
            <div class="timeline-item-content">Format tanggal harus sesuai (pengaturan umum)</div>
          </div>
          <div class="timeline-item">
            <div class="timeline-item-marker">
              <div class="timeline-item-marker-text">Kedua</div>
              <div class="timeline-item-marker-indicator"><i data-feather="check"></i></div>
            </div>
            <div class="timeline-item-content">NIK harus diisi</div>
          </div>
          <div class="timeline-item mb-3">
            <div class="timeline-item-marker">
              <div class="timeline-item-marker-text">Ketiga</div>
              <div class="timeline-item-marker-indicator"><i data-feather="check"></i></div>
            </div>
            <div class="timeline-item-content">Anda harus mengikuti file tersebut, jika tidak, Anda akan mendapatkan kesalahan saat mengimpor file.</div>
          </div>
        </div>
        <form action="{{ route('import.salary') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row gx-3 mb-3">
            <div class="mb-3 col-4">
              <input class="form-control" name="file" type="file" id="formFile" required>
            </div>
            <div class="mb-3 col-3">
              <button class="btn btn-primary" type="submit">Kirim File</button>
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
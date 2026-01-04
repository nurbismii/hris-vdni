<x-app-layout title="Edit SP">
  @push('styles')
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
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="edit-3"></i></div>
              Edit
            </h1>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-n10">
    <!-- Wizard card example with navigation-->
    <div class="card">
      <div class="card-body">
        <div class="row justify-content-center">
          <div class="col-xxl-6 col-xl-8">
            <h3 class="text-primary text-center">Form SP report</h3>
            <h5 class="card-title mb-4">
              <img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;" class="">
            </h5>
            <form action="/pengajuan/store-cuti" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">Employee name</label>
                  <input class="form-control" type="text" name="nama" value="{{ $data->employee->nama_karyawan }}" readonly />
                </div>
                <div class="col-md-6">
                  <label class="small mb-2">Departement</label>
                  <input class="form-control" name="departemen" type="text" value="{{ $data->employee->divisi->departemen->departemen }}" readonly />
                </div>
              </div>
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">Employee ID</label>
                  <input class="form-control" name="nik" type="text" value="{{ $data->nik_karyawan }}" readonly />
                </div>
                <div class="col-md-6">
                  <label class="small mb-2">Divisi</label>
                  <input class="form-control" name="tanggal_pengajuan" type="text" value="{{ $data->employee->divisi->nama_divisi }}" readonly />
                </div>
              </div>
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">NO SP</label>
                  <input class="form-control" name="nik" type="text" value="{{ $data->no_sp }}" />
                </div>
                <div class="col-md-6">
                  <label class="small mb-2">SP</label>
                  <select name="level_sp" class="form-select">
                    <option value="SP1" {{ $data->level_sp == 'SP1' ? 'selected' : '' }}>SP1</option>
                    <option value="SP2" {{ $data->level_sp == 'SP2' ? 'selected' : '' }}>SP2</option>
                    <option value="SP3" {{ $data->level_sp == 'SP3' ? 'selected' : '' }}>SP3</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12 mb-2">
                <label class="small mb-2">Information</label>
                <textarea name="keterangan" class="form-control" cols="30" rows="10">{{ $data->keterangan }}</textarea>
              </div>
              <div class="row gx-3 mb-2">
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">Start date</label>
                  <input class="form-control" name="tgl_mulai_cuti" type="date" value="{{ $data->tgl_mulai }}" required />
                </div>
                <div class="col-md-6 mb-2">
                  <label class="small mb-2">End date</label>
                  <input class="form-control" name="tgl_akhir_cuti" type="date" value="{{ $data->tgl_berakhir }}" required />
                </div>
              </div>
              <hr class="my-4" />
              <div class="d-flex justify-content-between">
                <button onclick="history.back()" class="btn btn-light" type="button">Back</button>
                <button class="btn btn-primary" type="submit">Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <x-toastr />

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="{{ asset('js/litepicker.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  @endpush

</x-app-layout>
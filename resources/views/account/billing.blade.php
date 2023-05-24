<x-app-layout title="Information">

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
              Informasi
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-blue" href="/account/profile">
              <i class="me-1" data-feather="x"></i>
              Tutup
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-4">
    <!-- Account page navigation-->
    <x-nav-account />

    <hr class="mt-0 mb-4" />
    <x-message />
    <div class="row">
      <div class="col-lg-6 mb-4">
        <!-- Billing card 1-->
        <div class="card h-100 border-start-lg border-start-primary">
          <div class="card-body">
            <div class="small text-muted">Gaji saat ini</div>
            <div class="h3">Rp.{{ number_format($salary->gaji_pokok) ?? 'Tidak diketahui'}}</div>
            <a class="text-arrow-icon small" href="#!">
              Detail
              <i data-feather="arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-6 mb-4">
        <!-- Billing card 3-->
        <div class="card h-100 border-start-lg border-start-success">
          <div class="card-body">
            <div class="small text-muted">Kontrak Berakhir</div>
            @if($contract)
            <div class="h3">{{ date('d F Y', strtotime($contract->tanggal_berakhir_kontrak)) ?? 'Belum di proses' }}</div>
            @endif
            <a class="text-arrow-icon small text-success" href="{{ route('contract') }}">
              Detail
              <i data-feather="arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Billing history card-->
    <div class="card mb-4">
      <div class="card-header">Riwayat Gaji</div>
      <div class="card-body p-0">
        <div class="table-responsive table-billing-history" style="overflow-x:auto;">
          <table class="table mb-0">
            <thead>
              <tr>
                <th class="border-gray-200" scope="col">ID Transaksi</th>
                <th class="border-gray-200" scope="col">Tanggal</th>
                <th class="border-gray-200" scope="col">Jumlah</th>
                <th class="border-gray-200" scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach($datas as $data)
              <tr>
                <td><a href="{{ route('invoice', $data->id) }}">#{{ strtoupper(substr($data->id, 0, 4)) }} </a></td>
                <td>{{ date('d F Y', strtotime($data->created_at)) }}</td>
                <td>Rp.{{ number_format($salary->gaji_pokok) ?? '#####'}}</td>
                <td><span class="badge bg-success">Success</span></td>
              </tr>
              @endforeach
            </tbody>
          </table>
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
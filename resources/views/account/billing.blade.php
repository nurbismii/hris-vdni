<x-app-layout title="Billing">

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
              Account Settings - Billing
            </h1>
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
    <div class="row">
      <div class="col-lg-4 mb-4">
        <!-- Billing card 1-->
        <div class="card h-100 border-start-lg border-start-primary">
          <div class="card-body">
            <div class="small text-muted">Current months salary</div>
            <div class="h3">$20.00</div>
            <a class="text-arrow-icon small" href="#!">
              Detail
              <i data-feather="arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <!-- Billing card 2-->
        <div class="card h-100 border-start-lg border-start-secondary">
          <div class="card-body">
            <div class="small text-muted">Next payment due</div>
            <div class="h3">July 15</div>
            <a class="text-arrow-icon small text-secondary" href="#!">
              Detail
              <i data-feather="arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      <div class="col-lg-4 mb-4">
        <!-- Billing card 3-->
        <div class="card h-100 border-start-lg border-start-success">
          <div class="card-body">
            <div class="small text-muted">End of Contract</div>
            <div class="h3">July 15</div>
            <a class="text-arrow-icon small text-success" href="#!">
              Detail
              <i data-feather="arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Billing history card-->
    <div class="card mb-4">
      <div class="card-header">Billing History</div>
      <div class="card-body p-0">
        <!-- Billing history table-->
        <div class="table-responsive table-billing-history">
          <table class="table mb-0">
            <thead>
              <tr>
                <th class="border-gray-200" scope="col">Transaction ID</th>
                <th class="border-gray-200" scope="col">Date</th>
                <th class="border-gray-200" scope="col">Amount</th>
                <th class="border-gray-200" scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>#39201</td>
                <td>06/15/2021</td>
                <td>$29.99</td>
                <td><span class="badge bg-light text-dark">Pending</span></td>
              </tr>
              <tr>
                <td>#38594</td>
                <td>05/15/2021</td>
                <td>$29.99</td>
                <td><span class="badge bg-success">Paid</span></td>
              </tr>
              <tr>
                <td>#38223</td>
                <td>04/15/2021</td>
                <td>$29.99</td>
                <td><span class="badge bg-success">Paid</span></td>
              </tr>
              <tr>
                <td>#38125</td>
                <td>03/15/2021</td>
                <td>$29.99</td>
                <td><span class="badge bg-success">Paid</span></td>
              </tr>
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
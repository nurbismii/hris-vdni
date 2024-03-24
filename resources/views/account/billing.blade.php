<x-app-layout title="Payslip">


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
	@endpush

	<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
		<div class="container-xl px-4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="user"></i></div>
							Payslip
						</h1>
					</div>
					<div class="col-12 col-xl-auto mb-3">
						<a class="btn btn-sm btn-light text-blue" href="/account/profile">
							<i class="me-1" data-feather="x"></i>
							Close
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Main page content-->
	<div class="container-xl px-4 mt-4">
		<hr class="mt-0 mb-4" />
		<x-message />
		<div class="row">
			<div class="col-lg-6 mb-3">
				<!-- Billing card 1-->
				<div class="card h-100 border-start-lg border-start-primary">
					<div class="card-body">
						<div class="small text-muted">Current salary</div>
						<div class="h3">Rp.{{ number_format($gaji_karyawan->gaji_pokok) ?? 'Tidak diketahui'}}</div>
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
						<div class="small text-muted">Contract expired</div>
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
			<!-- <div class="col-lg-12 mb-3">
				<form action="/roster/daftar-pengingat" method="get">
					@csrf
					<div class="card">
						<div class="card-body" style="overflow-x: auto;">
							<label for="">Period</label>
							<input type="month" name="periode" class="form-control">
							<div class="mt-2">
								<button class="btn btn-sm btn-light text-primary" type="submit">
									<i class="me-1" data-feather="search"></i>
									Filter
								</button>
								<a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalDeleteEmployee">
									<i class="me-1" data-feather="trash"></i>
									Remove filter
								</a>
							</div>
						</div>
					</div>
				</form>
			</div> -->
			@foreach($datas as $data)
			<div class="col-xl-4 mb-2">
				<a class="card card-angles lift-sm h-100" href="{{ route('invoice', $data->id) }}" role="button">
					<div class="card-body d-flex justify-content-center flex-column">
						<div class="d-flex align-items-center justify-content-between">
							<div class="me-3">
								<i class="feather-xl text-green mb-3" data-feather="dollar-sign"></i>
								<h5>#{{ strtoupper(substr($data->id, 0, 4)) }} | {{ date('d F Y', strtotime($data->mulai_periode)) }} - {{ date('d F Y', strtotime($data->akhir_periode)) }}</h5>
								<div class="text-muted small mb-2">Rp.{{ number_format($data->gaji_pokok, 0, ".", ",") ?? '#####'}}</div>
								<div<span class="badge bg-success">Success</span>
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach
		</div>
	</div>

	@push('scripts')
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
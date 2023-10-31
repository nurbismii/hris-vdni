<x-app-layout title="Severance Pay">
	@push('styles')
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
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

	<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
		<div class="container-fluid px-4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="user"></i></div>
							Severance Pay
						</h1>
					</div>
					<div class="col-12 col-xl-auto mb-3">
						<a class="btn btn-sm btn-light text-primary" href="/users/import">
							<i class="me-1" data-feather="upload-cloud"></i>
							Bulk
						</a>
						<a class="btn btn-sm btn-light text-primary" href="{{ route('severance.create') }}">
							<i class="me-1" data-feather="upload"></i>
							Add
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Main page content-->
	<div class="container-fluid px-4">
		<div class="card">
			<div class="card-body" style="overflow-x: auto;">
				<table id="datatablesSimple">
					<thead>
						<tr>
							<th>Employee ID</th>
							<th>Employee name</th>
							<th>Entry date</th>
							<th>Jabatan</th>
							<th>Termination date</th>
							<th>Severance pay</th>
							<th>Pasal</th>
							<th>Payroll period</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $row)
						<tr>
							<td>{{ $row->nik_karyawan }}</td>
							<td>{{ getName($row->nik_karyawan) }}</td>
							<td>{{ $row->employee->entry_date }}</td>
							<td>{{ $row->employee->posisi  }}</td>
							<td>{{ $row->termination_date }}</td>
							<td><b>{{ $row->total_severance }}</b></td>
							<td>{{ $row->pasal  }}</td>
							<td>{{ date('F Y', strtotime($row->payroll_period)) }}</td>
							<td>
								<a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('severance.print', $row->id) }}"><i data-feather="printer"></i></a>
								<a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="#"><i data-feather="edit"></i></a>
								<a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteUser"><i data-feather="trash-2"></i> </a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>


	@push('scripts')
	<x-toastr />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/scripts.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
	<script src="{{ asset('js/app.js')}}"></script>
	@endpush
</x-app-layout>
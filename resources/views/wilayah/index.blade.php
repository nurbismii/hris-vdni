<x-app-layout title="Wilayah">
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
		<div class="container-fluid px-s4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="user"></i></div>
							Wilayah
						</h1>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Main page content-->
	<div class="container-fluid px-4">
		<div class="col-xl-12 mb-1">
			<div class="card card-angles card-collapsable mb-3">
				<a class="card-header" href="#collapseFilterKaryawan" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">Filter area
					<div class="card-collapsable-arrow">
						<i class="fas fa-chevron-down"></i>
					</div>
				</a>
				<div class="collapse show" id="collapseFilterKaryawan">
					<form action="{{ url('wilayah') }}" method="get">
						@csrf
						<div class="card-body">
							<div class="row gx-3 mb-3">
								<div class="col-md-4 mb-2">
									<label class="small mb-1">Provinsi</label>
									<select name="provinsi_id" class="form-select" id="provinsi_id">
										<option value="" disabled selected>- Pilih provinsi -</option>
										@foreach($provinsi as $row)
										<option value="{{ $row->id }}">{{ $row->provinsi }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-4 mb-2">
									<label class="small mb-1">Kabupaten</label>
									<select name="kabupaten" class="form-select" id="kabupaten_id"></select>
								</div>
								<div class="col-md-4 mb-2">
									<label class="small mb-1">Kecamatan</label>
									<select name="kecamatan" class="form-select" id="kecamatan_id"></select>
								</div>
							</div>
							<button class="btn btn-sm btn-light text-primary" type="submit">
								<i class="me-1" data-feather="search"></i>
								Cari
							</button>
							<a class="btn btn-sm btn-light text-primary" href="/wilayah">
								<i class="me-1" data-feather="trash"></i>
								Bersihkan
							</a>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-body" style="overflow-x: auto;">
				<a href="{{ route('export-wilayah', ['provinsi' => $provinsi_id, 'kabupaten' => $kabupaten_id, 'kecamatan' => $kecamatan_id]) }}" class="btn btn-sm btn-success">Export excel</a>
				<table id="datatablesSimple" class="table table-hover">
					<thead>
						<tr>
							<th>Provinsi</th>
							<th>Kabupaten</th>
							<th>Kecamatan</th>
							<th>Kelurahan</th>
							<th>Total Karyawan Kel.</th>
						</tr>
					</thead>
					<tbody>
						@php
						$prevProvinsi = null;
						$prevKabupaten = null;
						$prevKecamatan = null;
						$totalKaryawan = 0;
						@endphp
						@foreach($response as $item)
						<tr>
							<td>
								@if($item['provinsi_id'] !== $prevProvinsi)
								{{ getNamaProvinsi($item['provinsi_id']) }}
								@php $prevProvinsi = $item['provinsi_id']; @endphp
								@endif
							</td>

							<td>
								@if($item['kabupaten_id'] !== $prevKabupaten)
								{{ getNamaKabupaten($item['kabupaten_id']) }}
								@php $prevKabupaten = $item['kabupaten_id']; @endphp
								@endif
							</td>

							<td>
								@if($item['kecamatan_id'] !== $prevKecamatan)
								{{ getNamaKecamatan($item['kecamatan_id']) }}
								@php $prevKecamatan = $item['kecamatan_id']; @endphp
								@endif
							</td>

							<td>
								@if($item['kelurahan_id'])
								<ul>
									<li>{{ getNamaKelurahan($item['kelurahan_id']) }}</li>
								</ul>
								@else
								<ul>
									<li>ID Kel. kosong</li>
								</ul>
								@endif
							</td>

							<td>
								{{ $item['jumlah_karyawan'] }}
							</td>

							@if($item['kelurahan_id'])
							@php $totalKaryawan += $item['jumlah_karyawan']; @endphp
							@endif

						</tr>
						@endforeach
						<tr>
							<td colspan="4" class="fw-800">Total karyawan kecamatan :</td>
							<td class="fw-800">{{ $totalKaryawan }} </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#provinsi_id').on('change', function() {
				var provinsiID = $(this).val();
				if (provinsiID) {
					$.ajax({
						url: 'dashboard/fetch-kabupaten/' + provinsiID,
						type: "GET",
						data: {
							"_token": "{{ csrf_token() }}"
						},
						dataType: "json",
						success: function(data) {
							if (data) {
								$('#kabupaten_id').empty();
								$('#kabupaten_id').append('<option hidden>- Pilih kabupaten -</option>');
								$.each(data, function(id, kabupaten) {
									$('select[name="kabupaten"]').append('<option value="' + kabupaten.id + '">' + kabupaten.kabupaten + '</option>');
								});
							} else {
								$('#kabupaten').empty();
							}
						}
					});
				} else {
					$('#kabupaten').empty();
				}
			});

			$('#kabupaten_id').on('change', function() {
				var kabupatenID = $(this).val();
				if (kabupatenID) {
					$.ajax({
						url: 'dashboard/fetch-kecamatan/' + kabupatenID,
						type: "GET",
						data: {
							"_token": "{{ csrf_token() }}"
						},
						dataType: "json",
						success: function(data) {
							if (data) {
								$('#kecamatan_id').empty();
								$('#kecamatan_id').append('<option hidden>- Pilih kecamatan -</option>');
								$.each(data, function(id, kecamatan) {
									$('select[name="kecamatan"]').append('<option value="' + kecamatan.id + '">' + kecamatan.kecamatan + '</option>');
								})
							} else {
								$('#kecamatan').empty();
							}
						}
					});
				}
			});

			$('#kecamatan_id').on('change', function() {
				var kecamatanID = $(this).val();
				if (kecamatanID) {
					$.ajax({
						url: 'dashboard/fetch-kelurahan/' + kecamatanID,
						type: "GET",
						data: {
							"_token": "{{ csrf_token() }}"
						},
						dataType: "json",
						success: function(data) {
							if (data) {
								$('#kelurahan_id').empty();
								$('#kelurahan_id').append('<option hidden>- Pilih kelurahan/desa -</option>');
								console.log(data);
								$.each(data, function(id, kelurahan) {
									$('select[name="kelurahan"]').append('<option value="' + kelurahan.id + '">' + kelurahan.kelurahan + '</option>');
								})
							} else {
								$('#kelurahan').empty();
							}
						}
					});
				}
			});
		});
	</script>

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
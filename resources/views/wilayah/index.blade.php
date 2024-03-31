<x-app-layout title="Wilayah">
	@push('styles')
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
	<link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
	<link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
	<script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Toastr -->
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<!-- Multiselect Bootstrap -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />
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
							<div class="row gx-4 mb-3">
								<div class="col-md-3 mb-2">
									<select name="company_id[]" multiple class="form-select" data-placeholder="Pilih perusahaan" id="company">
										<option value="VDNI">PT VDNI</option>
										<option value="VDNIP">PT VDNIP</option>
									</select>
								</div>
								<div class="col-md-3 mb-2">
									<select name="provinsi_level[]" multiple class="form-select-" data-placeholder="Pilih provinsi" id="provinsi_level">
										@foreach($provinsi as $row)
										<option value="{{ $row->id }}">{{ $row->provinsi }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3 mb-2">
									<select name="kabupaten_level[]" multiple class="form-select" data-placeholder="Pilih kabupaten" id="kabupaten_level"></select>
								</div>
								<div class="col-md-3 mb-2">
									<select name="kecamatan_level[]" multiple class="form-select" data-placeholder="Pilih kecamatan" id="kecamatan_level"></select>
								</div>
							</div>
							<button class="btn btn-primary float-end text-white" type="submit">
								<i class="me-1" data-feather="search"></i>
								Cari
							</button>
							<a class="btn btn-danger text-white" href="/wilayah">
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
				<a href="{{ route('export-wilayah-excel', ['area' => implode(',', $area_kerja), 'provinsi' => implode(',', $provinsi_id), 'kabupaten' => implode(',', $kabupaten_id), 'kecamatan' => implode(',', $kecamatan_id)]) }}" class="btn btn-success mb-2 mx-2 float-end">Export excel</a>
				<a href="{{ route('export-wilayah-pdf', ['area' => implode(',', $area_kerja), 'provinsi' => implode(',', $provinsi_id), 'kabupaten' => implode(',', $kabupaten_id), 'kecamatan' => implode(',', $kecamatan_id)]) }}" class="btn btn-danger mb-2 float-end">Export pdf</a>
				<div class="mt-5">
					<b>HASIL LAPORAN WILAYAH :</b>
					<div class="p-3">
						<table class="table table-bordered">
							<tr>
								<th width="20%">Area kerja</th>
								<td width="5px">:</td>
								<td>
									@for($i=0; $i < count($area_kerja); $i++) {{ $area_kerja[$i] }} @endfor </td>
							</tr>
							<tr>
								<th width="20%">Provinsi</th>
								<td width="5px">:</td>
								<td>@for($i=0; $i < count($provinsi_id); $i++) {{ getNamaProvinsi($provinsi_id[$i]) }} @endfor </td>
								</td>
							</tr>
							<tr>
								<th>Kabupaten</th>
								<td>:</td>
								<td>@for($i=0; $i < count($kabupaten_id); $i++) @if($i==count($kabupaten_id) - 2) {{getNamaKabupaten($kabupaten_id[$i])}} dan @else {{getNamaKabupaten($kabupaten_id[$i])}} @endif @if($i < count($kabupaten_id) - 2) , @endif @endfor .</td>
								</td>
							</tr>
							<tr>
								<th>Kecamatan</th>
								<td>:</td>
								<td>@for($i=0; $i < count($kecamatan_id); $i++) @if($i==count($kecamatan_id) - 2) {{ getNamaKecamatan($kecamatan_id[$i]) }} dan @else {{ getNamaKecamatan($kecamatan_id[$i]) }}@endif @if($i < count($kecamatan_id) - 2), @endif @endfor .</td>
								</td>
							</tr>
							<tr>
								<th>Jumlah kelurahan/desa</th>
								<td>:</td>
								<td>{{ count($response) }}</td>
							</tr>
						</table>
						<table id="datatablesSimpleWilayah" class="table table-bordered">
							<thead>
								<tr>
									<th>Daftar kelurahan/desa</th>
									<th>Total karyawan</th>
								</tr>
							</thead>
							<tbody>
								@php
								$totalKaryawan = 0;
								$no = 1;
								@endphp
								@foreach($response as $item)
								<tr>

									<td>
										@if($item['kelurahan_id'])
										{{ getNamaKelurahan($item['kelurahan_id']) }}
										@else
										BELUM DIKETAHUI
										@endif
									</td>

									<td width="25%">
										{{ $item['jumlah_karyawan'] }}
									</td>

									@if($item['kelurahan_id'])
									@php $totalKaryawan += $item['jumlah_karyawan']; @endphp
									@endif

								</tr>
								@endforeach
								<tr>
									<td colspan="1" class="fw-800">Total karyawan kecamatan :</td>
									<td class="fw-800">{{ $totalKaryawan }} </td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
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

			$('#company').multiselect({
				buttonWidth: '250px',
			});

			$('#provinsi_level').multiselect({
				buttonWidth: '250px',
				onChange: function(option, checked) {
					$('#kabupaten_level').html('');
					$('#kabupaten_level').multiselect('rebuild');
					$('#kecamatan_level').html('');
					$('#kecamatan_level').multiselect('rebuild');
					var selected = this.$select.val();
					if (selected.length > 0) {
						$.ajax({
							url: "/api/hrcorner/data-kabupaten",
							method: "POST",
							data: {
								selected: selected
							},
							success: function(data) {
								console.log(data);
								$('#kabupaten_level').html(data);
								$('#kabupaten_level').multiselect('rebuild');
							}
						})
					}
				}
			});

			$('#kabupaten_level').multiselect({
				buttonWidth: '250px',
				onChange: function(option, checked) {
					$('#kecamatan_level').html('');
					$('#kecamatan_level').multiselect('rebuild');
					var selected = this.$select.val();
					if (selected.length > 0) {
						$.ajax({
							url: "/api/hrcorner/data-kecamatan",
							method: "POST",
							data: {
								selected: selected
							},
							success: function(data) {
								$('#kecamatan_level').html(data);
								$('#kecamatan_level').multiselect('rebuild');
							}
						});
					}
				}
			});

			$('#kecamatan_level').multiselect({
				buttonWidth: '250px'
			});


			// $('#provinsi_id').on('change', function() {
			// 	var provinsiID = $(this).val();
			// 	if (provinsiID) {
			// 		$.ajax({
			// 			url: 'dashboard/fetch-kabupaten/' + provinsiID,
			// 			type: "GET",
			// 			data: {
			// 				"_token": "{{ csrf_token() }}"
			// 			},
			// 			dataType: "json",
			// 			success: function(data) {
			// 				if (data) {
			// 					$('#kabupaten_id').empty();
			// 					$('#kabupaten_id').append('<option hidden>- Pilih kabupaten -</option>');
			// 					$.each(data, function(id, kabupaten) {
			// 						$('select[name="kabupaten"]').append('<option value="' + kabupaten.id + '">' + kabupaten.kabupaten + '</option>');
			// 					});
			// 				} else {
			// 					$('#kabupaten').empty();
			// 				}
			// 			}
			// 		});
			// 	} else {
			// 		$('#kabupaten').empty();
			// 	}
			// });

			// $('#kabupaten_id').on('change', function() {
			// 	var kabupatenID = $(this).val();
			// 	if (kabupatenID) {
			// 		$.ajax({
			// 			url: 'dashboard/fetch-kecamatan/' + kabupatenID,
			// 			type: "GET",
			// 			data: {
			// 				"_token": "{{ csrf_token() }}"
			// 			},
			// 			dataType: "json",
			// 			success: function(data) {
			// 				if (data) {
			// 					$('#kecamatan_id').empty();
			// 					$('#kecamatan_id').append('<option hidden>- Pilih kecamatan -</option>');
			// 					$.each(data, function(id, kecamatan) {
			// 						$('select[name="kecamatan"]').append('<option value="' + kecamatan.id + '">' + kecamatan.kecamatan + '</option>');
			// 					})
			// 				} else {
			// 					$('#kecamatan').empty();
			// 				}
			// 			}
			// 		});
			// 	}
			// });

			// $('#kecamatan_id').on('change', function() {
			// 	var kecamatanID = $(this).val();
			// 	if (kecamatanID) {
			// 		$.ajax({
			// 			url: 'dashboard/fetch-kelurahan/' + kecamatanID,
			// 			type: "GET",
			// 			data: {
			// 				"_token": "{{ csrf_token() }}"
			// 			},
			// 			dataType: "json",
			// 			success: function(data) {
			// 				if (data) {
			// 					$('#kelurahan_id').empty();
			// 					$('#kelurahan_id').append('<option hidden>- Pilih kelurahan/desa -</option>');
			// 					console.log(data);
			// 					$.each(data, function(id, kelurahan) {
			// 						$('select[name="kelurahan"]').append('<option value="' + kelurahan.id + '">' + kelurahan.kelurahan + '</option>');
			// 					})
			// 				} else {
			// 					$('#kelurahan').empty();
			// 				}
			// 			}
			// 		});
			// 	}
			// });
		});
	</script>

	@push('scripts')
	<x-toastr />
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
	@endpush
</x-app-layout>
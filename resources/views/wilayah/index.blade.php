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
	<!-- Select2 Bootstrap -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
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
									<select name="company_id[]" class="form-select" data-placeholder="Pilih perusahaan" id="company" multiple>
										<option value="VDNI">PT VDNI</option>
										<option value="VDNIP">PT VDNIP</option>
									</select>
								</div>
								<div class="col-md-3 mb-2">
									<select name="provinsi_level[]" class="form-select" data-placeholder="Pilih provinsi" id="provinsi_level" multiple>
										@foreach($provinsi as $row)
										<option value="{{ $row->id }}">{{ $row->provinsi }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3 mb-2">
									<select name="kabupaten_level[]" class="form-select" data-placeholder="Pilih kabupaten" id="kabupaten_level" multiple></select>
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
						@foreach ($response as $kabupatenId => $kecamatans)
						@php
						$totalKaryawanKabupaten = 0;
						@endphp
						@foreach ($kecamatans as $kecamatanId => $karyawan)
						@php
						$totalKaryawanKecamatan = 0;
						@endphp
						<table class="table table-bordered">
							<thead>
								<tr class="table-primary">
									<th colspan="2" class="text-center text-uppercase">{{ getNamaKabupaten($kabupatenId) }}</th>
								</tr>
								<tr class="table-active">
									<th colspan="2" class="text-center text-uppercase">Kecamatan {{ getNamaKecamatan($kecamatanId) }}</th>
								</tr>
								<tr>
									<th>Kelurahan ID</th>
									<th>Jumlah Karyawan</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($karyawan as $data)
								<tr>
									<td>{{ getNamaKelurahan($data->kelurahan_id) }}</td>
									<td>{{ $data->jumlah_karyawan }}</td>
								</tr>
								@php
								$totalKaryawanKecamatan += $data->jumlah_karyawan;
								$totalKaryawanKabupaten += $data->jumlah_karyawan;
								@endphp
								@endforeach
								<tr>
									<td><strong>Total Karyawan Kecamatan</strong></td>
									<td><strong>{{ $totalKaryawanKecamatan }}</strong></td>
								</tr>
							</tbody>
						</table>
						@endforeach
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			// Inisialisasi Select2
			$('#company').select2({
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				theme: "bootstrap-5",
				allowClear: true,
				placeholder: 'Pilih Provinsi',
			});

			$('#provinsi_level').select2({
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				theme: "bootstrap-5",
				allowClear: true,
				placeholder: 'Pilih Provinsi',
			});

			$('#kabupaten_level').select2({
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				theme: "bootstrap-5",
				allowClear: true,
				placeholder: 'Pilih kabupaten',
			});

			$('#kecamatan_level').select2({
				width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
				theme: "bootstrap-5",
				allowClear: true,
				placeholder: 'Pilih kabupaten',
			});

			// Definisikan variabel selectedValues di luar blok event
			var selectedValuesProv = [];

			// Event select2:select
			$('#provinsi_level').on('select2:select', function(e) {
				var selectedValue = e.params.data.id;
				selectedValuesProv.push(selectedValue);
				console.log(selectedValuesProv);

				// Kirim nilai array ke endpoint
				postSelectedValuesToEndpointProv(selectedValuesProv);
			});

			// Event select2:unselect
			$('#provinsi_level').on('select2:unselect', function(e) {
				var unselectedValue = e.params.data.id;
				var index = selectedValues.indexOf(unselectedValue);
				if (index !== -1) {
					selectedValuesProv.splice(index, 1);
				}
				console.log(selectedValuesProv);

				// Kirim nilai array ke endpoint
				postSelectedValuesToEndpointProv(selectedValuesProv);
			});

			// Fungsi untuk mengirim nilai array ke endpoint
			function postSelectedValuesToEndpointProv(selectedValuesProv) {
				if (selectedValuesProv.length > 0) {
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "/api/hrcorner/data-kabupaten",
						method: "POST",
						data: {
							selectedValuesProv: selectedValuesProv
						},
						success: function(data) {
							$('#kabupaten_level').html(data);
							$('#kabupaten_level').select2('destroy').select2();
							// Lakukan sesuatu dengan respons dari server (opsional)
						},
						error: function(xhr, status, error) {
							console.error("Kesalahan:", error);
							// Tangani kesalahan jika diperlukan (opsional)
						}
					});
				}
			}


			var selectedValuesKab = [];

			// Event select2:select
			$('#kabupaten_level').on('select2:select', function(e) {
				var selectedValue = e.params.data.id;
				selectedValuesKab.push(selectedValue);
				console.log(selectedValuesKab);

				// Kirim nilai array ke endpoint
				postSelectedValuesToEndpointKab(selectedValuesKab);
			});

			// Event select2:unselect
			$('#kabupaten_level').on('select2:unselect', function(e) {
				var unselectedValue = e.params.data.id;
				var index = selectedValues.indexOf(unselectedValue);
				if (index !== -1) {
					selectedValuesKab.splice(index, 1);
				}
				console.log(selectedValuesKab);

				// Kirim nilai array ke endpoint
				postSelectedValuesToEndpointKab(selectedValuesKab);
			});

			// Fungsi untuk mengirim nilai array ke endpoint
			function postSelectedValuesToEndpointKab(selectedValuesKab) {
				if (selectedValuesKab.length > 0) {
					$.ajax({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						},
						url: "/api/hrcorner/data-kecamatan",
						method: "POST",
						data: {
							selectedValuesKab: selectedValuesKab
						},
						success: function(data) {
							$('#kecamatan_level').html(data);
							$('#kecamatan_level').select2('destroy').select2();
							// Lakukan sesuatu dengan respons dari server (opsional)
						},
						error: function(xhr, status, error) {
							console.error("Kesalahan:", error);
							// Tangani kesalahan jika diperlukan (opsional)
						}
					});
				}
			}
		});
	</script>

	@push('scripts')
	<x-toastr />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
	@endpush
</x-app-layout>
<x-app-layout title="Mutasi">
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
	<!-- Select2 -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<style>
		.select2 {
			width: 100% !important;
			overflow: hidden !important;
			height: auto !important;
		}
	</style>
	<!-- Datepicker -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/js/bootstrap-datepicker.min.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/css/datepicker.min.css" rel="stylesheet">
	@endpush
	<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
		<div class="container-xl px-4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="book-open"></i></div>
							Mutasi karyawan
						</h1>
					</div>
					<div class="col-12 col-xl-auto mb-3">
						<a class="btn btn-sm btn-light text-blue" href="/employees">
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
		<!-- Wizard card example with navigation-->
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-xxl-10 col-xl-8">
						<h3 class="text-primary text-center">Formulir Permohonan Mutasi</h3>
						<h5 class="card-title mb-4">
							<img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;" class="">
						</h5>
						<form action="{{ route('mutasi.update') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="mb-3">
								<select class="form-select search" name="nik" id="nik"></select>
							</div>
							<hr class="mt-2 mb-2">
							<div class="row">
								<div class="table-responsive col-lg-6">
									<table class="table table-borderless mb-2">
										<thead class="border-bottom">
											<tr class="small text-uppercase text-muted">
												<th scope="col">Posisi awal</th>
											</tr>
										</thead>
										<tbody>
											<tr class="border-bottom">
												<td colspan="2">
													<div class="col-md-12 mb-2">
														<label class="small mb-2">Nama</label>
														<input class="form-control" type="text" name="nama" id="nama_karyawan" readonly />
													</div>
												</td>
											</tr>
											<tr class="border-bottom">
												<td colspan="2">
													<div class="col-md-12">
														<label class="small mb-2">Departemen</label>
														<input class="form-control" name="departemen" type="text" id="departemen" readonly />
													</div>
												</td>
											</tr>
											<tr class="border-bottom">
												<td colspan="2">
													<div class="col-md-12">
														<label class="small mb-2">Jabatan</label>
														<input class="form-control" name="posisi" type="text" id="posisi" readonly />
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="table-responsive col-lg-6">
									<table class="table table-borderless mb-0">
										<thead class="border-bottom">
											<tr class="small text-uppercase text-muted">
												<th scope="col">Mutasi</th>
											</tr>
										</thead>
										<tbody>
											<tr class="border-bottom">
												<td colspan="2">
													<div class="col-md-12 mb-2">
														<label class="small mb-2">Departemen</label>
														<select name="departemen_id" class="form-select departemen" required>
															<option value="">- Select a departement -</option>
															@foreach($depts as $d)
															<option value="{{ $d->id }}">{{ $d->departemen }}</option>
															@endforeach
														</select>
													</div>
												</td>
											</tr>
											<tr class="border-bottom">
												<td colspan="2">
													<div class="col-md-12 mb-2">
														<label class="small mb-2">Divisi</label>
														<select class="form-select" name="divisi_id" id="divisi" required></select>
													</div>
												</td>
											</tr>
											<tr class="border-bottom">
												<td colspan="2">
													<div class="col-md-12">
														<label class="small mb-2">Jabatan</label>
														<input class="form-control" name="posisi" type="text" required/>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="mb-3">
								<label class="small mb-2">Lokasi kerja</label>
								<select name="area_kerja" class="form-select" required>
									<option value="" disabled selected>- Pilih lokasi kerja -</option>
									<option value="VDNI">PT VDNI</option>
									<option value="OSS">PT OSS</option>
									<option value="GNI">PT GNI</option>
								</select>
							</div>
							<div class="mb-3">
								<label for="" class="mb-2">Tanggal efektif</label>
								<input type="text" name="tanggal_mutasi" class="form-control date" required>
							</div>
							<div class="mb-3">
								<label for="" class="mb-2">Berkas pendukung</label>
								<input type="file" name="file" class="form-control">
							</div>
							<hr class="my-4" />
							<div class="d-grid">
								<button class="btn btn-primary" type="submit">Simpan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
	<x-toastr />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
		$(".date").datepicker({
			format: "dd-mm-yyyy",
			autoclose: true //to close picker once year is selected
		});

		$('.search').select2({
			width: 'resolve',
			theme: 'classic',
			placeholder: 'Search employee...',
			ajax: {
				url: '/api/hrcorner/search-employee',
				dataType: 'json',
				delay: 250,
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: item.nik + ' - ' + item.nama_karyawan,
								id: item.nik
							}
						})
					};
				},
				cache: true
			}
		});

		$('.search-kota').select2({
			width: 'resolve',
			placeholder: 'Pilih kota...',
			ajax: {
				url: '/api/hrcorner/airports',
				dataType: 'json',
				delay: 250,
				processResults: function(data) {
					return {
						results: $.map(data, function(item) {
							return {
								text: item.name + ' | ' + item.iata_code,
								id: item.name
							}
						})
					};
				},
				cache: true
			}
		});

		$('#nik').on('change', function() {
			var id = $(this).val();
			if (id) {
				$.ajax({
					url: '/api/hrcorner/detail-employee/' + id,
					type: "GET",
					data: {
						"_token": "{{ csrf_token() }}"
					},
					dataType: "json",
					success: function(data) {
						if (data) {
							$('.nik_karyawan').val(data.nik);
							$('#nama_karyawan').val(data.nama_karyawan);
							$('#departemen').val(data.departemen);
							$('#divisi').val(data.nama_divisi);
							$('#posisi').val(data.posisi);
							$('#jabatan').val(data.jabatan);
							$('#sisa_cuti').val(data.sisa_cuti);
						}
					}
				});
			}
		});
	</script>
	<script src="{{ asset('js/scripts.js') }}"></script>
	<script src="{{ asset('js/chart.min.js') }}" crossorigin="anonymous"></script>
	<script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
	<script src="{{ asset('js/litepicker.js')}}"></script>
	<script src="{{ asset('js/app.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script>
		$(document).ready(function() {
			$('.departemen').on('change', function() {
				var deptID = $(this).val();
				if (deptID) {
					$.ajax({
						url: '/api/hrcorner/divisi/' + deptID,
						type: "GET",
						data: {
							"_token": "{{ csrf_token() }}"
						},
						dataType: "json",
						success: function(data) {
							if (data) {
								$('#divisi').empty();
								$('#divisi').append('<option hidden>- Pilih Divisi -</option>');
								$.each(data, function(id, divisi) {
									$('select[name="divisi_id"]').append('<option value="' + divisi.id + '">' + divisi.nama_divisi + '</option>');
								});
							} else {
								$('#divisi').empty();
							}
						}
					});
				} else {
					$('#divisi').empty();
				}
			});
		});
	</script>
	@endpush

</x-app-layout>
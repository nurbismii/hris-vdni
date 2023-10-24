<x-app-layout title="Add salary">
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
		span.select2.select2-container.select2-container--classic {
			width: 100% !important;
		}
	</style>
	@endpush

	<header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
		<div class="container-xl px-4">
			<div class="page-header-content pt-4">
				<div class="row align-items-center justify-content-between">
					<div class="col-auto mt-4">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="edit-3"></i></div>
							Salary
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
					<div class="col-xxl-8 col-xl-8">
						<h3 class="text-primary text-center">Form Salary</h3>
						<h5 class="card-title mb-4">
							<img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;">
						</h5>
						<form action="{{ route('store/gaji-karyawan') }}" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
							<div class="modal-body">
								@csrf
								<div class="row gx-3 mb-2">
									<div class="col-md-12 mb-2">
										<label class="small mb-2">Employee ID</label>
										<select class="form-select search" name="search" id="karyawan"></select>
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Departemen</label>
										<input class="form-control" name="departemen" type="text" id="departemen" readonly />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Divisi</label>
										<input class="form-control" name="divisi" type="text" id="divisi" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Posisi</label>
										<input class="form-control" name="posisi" type="text" id="posisi" readonly />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Jabatan</label>
										<input class="form-control" name="jabatan" type="text" id="jabatan" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Status Gaji</label>
										<select class="form-select" name="status_gaji" id="">
											<option value="">-</option>
											<option value="all-in">All In</option>
										</select>
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Jumlah Hari Kerja</label>
										<input class="form-control @error('jumlah_hari_kerja') is-invalid @enderror " name="jumlah_hari_kerja" type="number" />
										@error('jumlah_hari_kerja')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Tunjangan Umum</label>
										<input class="form-control" name="tunj_umum" type="text" />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Tunjangan Pengawas</label>
										<input class="form-control" name="tunj_pengawas" type="text" />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Tunjangan Transport Pulsa</label>
										<input class="form-control" name="tunj_transport_pulsa" type="text" />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Tunjangan Masa Kerja</label>
										<input class="form-control" name="tunj_masa_kerja" type="text" />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">Tunjangan Koefisien Jabatan</label>
										<input class="form-control" name="tunj_koefisien_jabatan" type="text" />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Tunjangan Lapangan</label>
										<input class="form-control" name="tunj_lap" type="text" />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">Tunjangan Uang Makan</label>
										<input class="form-control @error('tunj_makan') is-invalid @enderror" name="tunj_makan" id="rupiah_makan" type="text" />
										@error('tunj_makan')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Gaji Pokok</label>
										<input class="form-control @error('gaji_pokok') is-invalid @enderror" name="gaji_pokok" id="rupiah_gaji" type="text" />
										@error('gaji_pokok')
										<span class="invalid-feedback">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a class="btn btn-secondary" type="button" href="{{ url()->previous() }}">Back</a>
								<button class="btn btn-success" type="submit">Send</button>
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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/litepicker.js')}}"></script>
	<script src="{{ asset('js/app.js')}}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
		$('.search').select2({
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
								text: item.nama_karyawan,
								id: item.nik
							}
						})
					};
				},
				cache: true
			}
		});

		$(document).ready(function() {
			$('#karyawan').on('change', function() {
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
							console.log(data)
							if (data) {
								$('#departemen').val(data.departemen);
								$('#divisi').val(data.nama_divisi);
								$('#posisi').val(data.posisi);
								$('#jabatan').val(data.jabatan);
							}
						}
					});
				}
			});
		});
	</script>


	@endpush

</x-app-layout>
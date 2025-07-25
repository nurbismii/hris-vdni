<x-app-layout title="Data pengunduran diri">
	@push('styles')
	<link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
	<script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/datetime/1.4.0/css/dataTables.dateTime.min.css" rel="stylesheet" />
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
							<div class="page-header-icon"><i data-feather="users"></i></div>
							Data pengunduran diri
						</h1>
					</div>
					<div class="col-12 col-xl-auto mb-3">
						<a class="btn btn-sm btn-light text-primary" href="/industrial-relations/resign/import">
							<i class="me-1" data-feather="upload-cloud"></i>
							Bulk upload
						</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Main page content-->
	<div class="container-fluid px-4">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body" style="overflow-x:auto;">
						<table id="data-table-resign" class="table table-hover" style="width: 100%;">
							<div class="row gx-3 mb-3">
								<div class="col-md-3 mb-2">
									<label class="small mb-1">Status Keluar</label>
									<select class="form-select" id="status_resign">
										<option value="">- Pilih status keluar -</option>
										<option value="RESIGN SESUAI PROSEDUR">RESIGN SESUAI PROSEDUR</option>
										<option value="RESIGN TIDAK SESUAI PROSEDUR">RESIGN TIDAK SESUAI PROSEDUR</option>
										<option value="PHK">PHK</option>
										<option value="PHK PENSIUN">PHK PENSIUN</option>
										<option value="PHK MENINGGAL DUNIA">PHK MENINGGAL DUNIA</option>
										<option value="PHK PIDANA">PHK PIDANA</option>
										<option value="PB PHK">PB PHK</option>
										<option value="PB RESIGN">PB RESIGN</option>
										<option value="PUTUS KONTRAK">PUTUS KONTRAK</option>
									</select>
								</div>
								<div class="col-md-6 mb-2">
									<label class="small mb-1">Periode keluar</label>
									<div class="input-group">
										<input type="month" name="periode_resign" id="periode_resign" class="form-control">
									</div>
								</div>
							</div>
							<hr class="mt-0 mb-4" />
							<thead>
								<tr>
									<th>NIK</th>
									<th>Nama</th>
									<th>Tanggal resign</th>
									<th>Tipe</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody> </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
	<x-toastr />

	<script type="text/javascript">
		function confirmReject() {
			return confirm('Kamu yakin ingin menolak pengajuan ini ?');
		}

		function confirmDestroy() {
			return confirm('Kamu yakin ingin menghapus pengajuan ini ?');
		}
	</script>

	<script src="{{ asset('js/scripts.js') }}"></script>
	<script src="{{ asset('js/chart.min.js') }}" crossorigin="anonymous"></script>
	<script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
	<script src="{{ asset('js/litepicker.js')}}"></script>
	<script src="{{ asset('js/app.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

	<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
	<script src="https://cdn.datatables.net/datetime/1.4.0/js/dataTables.dateTime.min.js"></script>

	<script>
		$(function() {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var searchTimeout;
			var table = $('#data-table-resign').DataTable({
				pageLength: 10,
				processing: true,
				serverSide: true,
				searching: true,
				responsive: true,
				ajax: {
					url: "/industrial-relations/server-side/resign",
					data: function(d) {
						d.tipe = $('#tipe').val()
						d.search = $('input[type="search"]').val()
						d.periode_resign = $('#periode_resign').val()
					}
				},

				columns: [{
						data: 'nik_karyawan',
						name: 'nik_karyawan'
					},
					{
						data: 'employee.nama_karyawan',
						name: 'employee.nama_karyawan'
					},
					{
						data: 'tanggal_keluar',
						name: 'tanggal_keluar'
					},
					{
						data: 'tipe',
						name: 'tipe'
					},
					{
						data: 'action',
						name: 'action',
						orderable: false
					},
				],
				order: [
					[0, 'desc']
				]
			});

			$('#tipe').change(function() {
				table.draw();
			});

			$('#periode_resign').change(function() {
				table.draw();
			});

			// Delay search for 5 seconds after typing in search box
			$('input[type="search"]').off('input').on('input', function() {
				clearTimeout(searchTimeout);
				searchTimeout = setTimeout(function() {
					table.draw();
				}, 5000);
			});
		});
	</script>
	@endpush
</x-app-layout>
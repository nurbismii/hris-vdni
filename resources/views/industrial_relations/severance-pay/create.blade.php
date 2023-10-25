<x-app-layout title="Severance pay">

	@push('styles')
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
							<div class="page-header-icon"><i data-feather="dollar-sign"></i></div>
							Severance Pay
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
						<h3 class="text-primary text-center">Form severance pay</h3>
						<h5 class="card-title mb-4">
							<img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;">
						</h5>
						<div class="mb-3">
							<select class="form-select search" name="search" id="nik"></select>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Employee ID</label>
								<input class="form-control" name="nik_karyawan" type="text" id="nik_karyawan" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Employee name</label>
								<input class="form-control" name="nama_karyawan" type="text" id="nama_karyawan" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Departement</label>
								<input class="form-control" name="departemen" type="text" id="departemen" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Divisi</label>
								<input class="form-control" name="divisi" type="text" id="divisi" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Position</label>
								<input class="form-control" name="posisi" type="text" id="posisi" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Job title</label>
								<input class="form-control" name="jabatan" type="text" id="jabatan" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Entry date</label>
								<input class="form-control" name="entry_date" type="text" id="entry_date" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Employee status</label>
								<input class="form-control" name="employee_status" type="text" id="status_karyawan" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Province</label>
								<input class="form-control" name="entry_date" type="text" id="provinsi" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Regency</label>
								<input class="form-control" name="employee_status" type="text" id="kabupaten" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">District</label>
								<input class="form-control" name="entry_date" type="text" id="kecamatan" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Village</label>
								<input class="form-control" name="employee_status" type="text" id="kelurahan" readonly />
							</div>
						</div>
						<div class="col-md-12 mb-2">
							<label class="small mb-2">Alamat</label>
							<input class="form-control" name="pronvince" type="text" id="alamat" readonly />
						</div>
						<div class="col-md-12 mb-2">
							<label class="small mb-2">SP Level</label>
							<input class="form-control" name="level_sp" type="text" id="level_sp" readonly />
						</div>
						<div class="mb-2">
							<label class="small mb-1">Select pasal</label>
							<select class="form-select" name="pasal" id="list-pasal">
								<option value="" selected>Select pasal :</option>
								@foreach($pasal as $row)
								<option value="{{ $row->pasal }}">{{ $row->pasal }}</option>
								@endforeach
							</select>
						</div>

						<form action="" method="post" id="form521">
							<div class="table-responsive">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<th scope="row">Severance pay</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_severance" id="bil_severance521" maxlength="3" value="0.5" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="service_year" id="service_year521" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="hidden" name="net_salary" id="net_salary" readonly>
													<input class="form-control" type="text" id="net_salary_rp" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_severance" id="subtotal_severance521" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Award money</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="service_year" id="service_month_award" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="hidden" name="net_salary_award" id="net_salary_award" readonly>
													<input class="form-control" type="text" id="net_salary_award_rp" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_award" id="subtotal_award" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Reimbursement of rights</th>
											<td>:</td>
										</tr>
										<tr>
											<th>a. Annual leave</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="remaining_leave" id="remaining_leave521" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="hidden" name="basic_salary" id="basic_salary" readonly>
													<input class="form-control" type="text" id="basic_salary_rp" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_annual" value="25" id="bil_annual" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_annual" id="subtotal_annual" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th>b. Return cost</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="return_cost" id="return_cost">
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="" id="">
							</div>

							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="" id="">
							</div>

							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>

						<form action="" method="post" id="form51">
							<div class="table-responsive">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<th scope="row">Servance payment</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_severance" placeholder="0,25">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="net_salary" id="net_salary" placeholder="Total salary">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_severance" id="subtotal_severance" placeholder="Subtotal severance pay">
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Reimbursement of rights</th>
											<td>:</td>
										</tr>
										<tr>
											<th>a. Annual leave</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="remaining_leave51" id="remaining_leave51">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="basic_salary" id="basic_salary">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_annual" value="25" id="bil_annual" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_annual" placeholder="Subtotal annual leave">
												</div>
											</td>
										</tr>
										<tr>
											<th>b. Return cost</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="number" name="" placeholder="Return cost">
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="" id="">
							</div>

							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="" id="">
							</div>

							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>

						<form action="" method="post" id="form16">
							<div class="table-responsive">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<th scope="row">Kompensasi</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="service_year" id="service_month">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="net_salary" placeholder="Total salary">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_compensation" value="12" readonly>
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="" id="">
							</div>

							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="" id="">
							</div>

							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>

						<form action="" method="post" id="form522">
							<div class="table-responsive">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<th scope="row">Servance pay</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_severance" id="bil_severance" placeholder="0,5">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="total_salary" id="total_salary" placeholder="Total salary">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_severance" id="subtotal_severance">
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Award money</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="service_year" id="service_year522">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="total_salary" placeholder="Total salary">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_award" placeholder="Subtotal award">
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Reimbursement of rights</th>
											<td>:</td>
										</tr>
										<tr>
											<th>a. Annual leave</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="remaining_leave522" id="remaining_leave522">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="basic_salary" id="basic_salary">
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_annual" value="25" id="bil_annual" readonly>
												</div>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_annual" placeholder="Subtotal annual leave">
												</div>
											</td>
										</tr>
										<tr>
											<th>b. Return cost</th>
											<td>
												<div class="mb-2">
													<input class="form-control" type="number" name="return_cost" placeholder="Return cost">
												</div>
											</td>
										</tr>
									</tbody>
								</table>
							</div>

							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="" id="">
							</div>

							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="" id="">
							</div>

							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	@push('scripts')
	<x-toastr />
	<script>
		$(document).ready(function() {
			// Menghilangkan form-input ketika pertama kali dijalankan

			$("#form521").css("display", "none");
			$("#form522").css("display", "none");
			$("#form51").css("display", "none");
			$("#form40").css("display", "none");
			$("#form16").css("display", "none");

			// Menghilangkan form-input ketika pertama kali dijalankan end

			$('#list-pasal').change(function() {
				if ($(this).val() === "52 ayat (1)") {
					$("#form521").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
				} else {
					$("#form521").slideUp("fast");
				}
				if ($(this).val() === "52 ayat (2)") {
					$("#form522").slideDown("fast");
				} else {
					$("#form522").slideUp("fast");
				}
				if ($(this).val() === "51") {
					$("#form51").slideDown("fast");
				} else {
					$("#form51").slideUp("fast");
				}
				if ($(this).val() === "40") {
					$("#form40").slideDown("fast");
				} else {
					$("#form40").slideUp("fast");
				}
				if ($(this).val() === "16") {
					$("#form16").slideDown("fast");
				} else {
					$("#form16").slideUp("fast");
				}
			})

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
								$('#nik_karyawan').val(data.nik);
								$('#nama_karyawan').val(data.nama_karyawan);
								$('#departemen').val(data.departemen);
								$('#divisi').val(data.nama_divisi);
								$('#posisi').val(data.posisi);
								$('#jabatan').val(data.jabatan);
								$('#entry_date').val(data.entry_date);
								$('#status_karyawan').val(data.status_karyawan);
								$('#provinsi').val(data.provinsi);
								$('#kabupaten').val(data.kabupaten);
								$('#kecamatan').val(data.kecamatan);
								$('#kelurahan').val(data.kelurahan);
								$('#alamat').val(data.alamat_ktp);
								$('#net_salary').val(data.total_diterima);
								$('#net_salary_rp').val(formatRupiah(data.total_diterima, "Rp. "));
								$('#net_salary_award').val(data.total_diterima);
								$('#net_salary_award_rp').val(formatRupiah(data.total_diterima, "Rp. "));
								$('#basic_salary').val(data.gaji_pokok);
								$('#basic_salary_rp').val(formatRupiah(data.gaji_pokok, "Rp. "));
								$('#remaining_leave521').val(data.sisa_cuti);
								$('#remaining_leave522').val(data.sisa_cuti);
								$('#service_year521').val(data.service_year);
								$('#service_year522').val(data.service_year);
								$('#service_month_award').val(checkMonthYear(data.service_month));
								$('#service_month').val(data.service_month);
								$('#level_sp').val(data.spreport.level_sp);
							}
						}
					});
				}
			});

			$("#list-pasal").on('change', function() {
				var subtotal_severance521 = (parseFloat($('#bil_severance521').val()) * parseInt($('#service_year521').val())) * parseInt($('#net_salary').val());
				$('#subtotal_severance521').val(subtotal_severance521);

				var subtotal_severance521 = document.getElementById("subtotal_severance521").value;

				if (subtotal_severance521 > 0) {
					$('#subtotal_severance521').val(formatRupiah(subtotal_severance521, "Rp. "));
				}

				var subtotal_award = parseInt($('#service_month_award').val()) * parseInt($('#net_salary').val());
				$('#subtotal_award').val(subtotal_award);

				var subtotal_award = document.getElementById("subtotal_award").value;

				if (subtotal_award > 0) {
					$('#subtotal_award').val(formatRupiah(subtotal_award, "Rp. "));
				}

				var subtotal_annual = (parseFloat($('#remaining_leave521').val()) * parseInt($('#basic_salary').val())) / parseInt($('#bil_annual').val());
				$('#subtotal_annual').val(subtotal_annual);

				var subtotal_annual = document.getElementById("subtotal_annual").value;

				if (subtotal_annual > 0) {
					$('#subtotal_annual').val(formatRupiah(subtotal_annual, "Rp. "));
				}
			});

			var return_cost = document.getElementById("return_cost");
			return_cost.addEventListener("keyup", function(e) {
				// tambahkan 'Rp.' pada saat form di ketik
				// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
				return_cost.value = formatRupiah(this.value, "Rp. ");
			});

			function checkMonthYear(data) {
				var data;
				if (data <= '35') {
					data = '0'
				}
				if (data >= '36' && data <= '72') {
					data = '2'
				}
				if (data >= '72' && data <= '108') {
					data = '3'
				}
				if (data >= '109' && data <= '144') {
					data = '4'
				}
				return data
			}

			/* Fungsi formatRupiah */
			function formatRupiah(angka, prefix) {
				var number_string = angka.replace(/[^,\d]/g, "").toString(),
					split = number_string.split(","),
					sisa = split[0].length % 3,
					rupiah = split[0].substr(0, sisa),
					ribuan = split[0].substr(sisa).match(/\d{3}/gi);

				// tambahkan titik jika yang di input sudah menjadi angka ribuan
				if (ribuan) {
					separator = sisa ? "." : "";
					rupiah += separator + ribuan.join(".");
				}

				rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
				return prefix == undefined ? rupiah : rupiah ? "Rp" + rupiah : "";
			}
		});
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
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
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/scripts.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/litepicker.js')}}"></script>
	<script src="{{ asset('js/app.js')}}"></script>
	@endpush

</x-app-layout>
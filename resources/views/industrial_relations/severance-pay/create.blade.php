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
							Perhitungan pesangon
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
						<h3 class="text-primary text-center">Formulir perhitungan pesangon</h3>
						<h5 class="card-title mb-4">
							<img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;">
						</h5>
						<div class="mb-3">
							<select class="form-select search" name="search" id="nik"></select>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">NIK</label>
								<input class="form-control nik_karyawan" name="nik_karyawan" type="text" id="nik_karyawan" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Nama</label>
								<input class="form-control" name="nama_karyawan" type="text" id="nama_karyawan" readonly />
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
								<label class="small mb-2">Tanggal masuk</label>
								<input class="form-control" name="entry_date" type="text" id="entry_date" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Status kontrak</label>
								<input class="form-control" name="employee_status" type="text" id="status_karyawan" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Provinsi</label>
								<input class="form-control" name="entry_date" type="text" id="provinsi" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Kabupaten</label>
								<input class="form-control" name="employee_status" type="text" id="kabupaten" readonly />
							</div>
						</div>
						<div class="row gx-3 mb-2">
							<div class="col-md-6">
								<label class="small mb-2">Kecamatan</label>
								<input class="form-control" name="entry_date" type="text" id="kecamatan" readonly />
							</div>
							<div class="col-md-6">
								<label class="small mb-2">Kelurahan</label>
								<input class="form-control" name="employee_status" type="text" id="kelurahan" readonly />
							</div>
						</div>
						<div class="col-md-12 mb-2">
							<label class="small mb-2">Alamat</label>
							<input class="form-control" name="pronvince" type="text" id="alamat" readonly />
						</div>
						<div class="col-md-12 mb-2">
							<label class="small mb-2">Tingkat SP</label>
							<input class="form-control" name="level_sp" type="text" id="level_sp" readonly />
						</div>

						<div class="mb-2">
							<label class="small mb-1">Pasal</label>
							<select class="form-select" name="pasal" id="list-pasal">
								<option value="" selected>Pilih pasal :</option>
								@foreach($pasal as $row)
								<option value="{{ $row->pasal }}">{{ $row->pasal }}</option>
								@endforeach
							</select>
						</div>

						<form action="{{ route('severance.store') }}" method="post" id="form521">
							@csrf
							<input class="form-control nik_karyawan" name="nik_karyawan" type="hidden" readonly />
							<input class="form-control pasal" name="pasal" type="hidden" readonly />
							<input class="form-control" type="hidden" name="net_salary" id="net_salary">
							<input class="form-control" type="hidden" name="basic_salary" id="basic_salary">
							<div class="table-responsive">
								<table class="table table-hover mb-0 text-align">
									<tbody>
										<tr>
											<th scope="row">Uang pesangon</th>
											<td>Variabel pesangon <sup>(*)</sup></td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_severance" id="bil_severance521" maxlength="3" value="0.5" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Masa kerja</td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control service_year" type="text" name="service_year" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Gaji pokok</td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control net_salary" type="text" name="net_salary" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<th>Subtotal pesangon</th>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_severance" id="subtotal_severance521" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row">Uang penghargaan</th>
											<td>Variabel penghargaan <sup>(*)</sup></td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="service_year_award" id="service_month_award" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Gaji pokok</td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control net_salary" type="text" name="net_salary_award" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<th>Subtotal penghargaan</th>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_award" id="subtotal_award" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th scope="row" colspan="2">Penggantian hak</th>
											<td>:</td>
											<td></td>
										</tr>
										<tr>
											<th>a. Cuti tahunan</th>
											<td>Jumlah cuti tahunan</td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control remaining_leave" type="text" name="remaining_leave" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Gaji pokok</td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control basic_salary" type="text" name="basic_salary" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Variabel cuti tahunan <sup class="text-danger">*</sup></td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="bil_annual" value="25" id="bil_annual" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<th>Subtotal cuti tahunan</th>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="subtotal_annual" id="subtotal_annual" readonly>
												</div>
											</td>
										</tr>
										<tr>
											<th colspan="2">b. Biaya pulang</th>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control" type="text" name="return_cost" id="return_cost521" required>
												</div>
											</td>
										</tr>
										<tr>
											<th colspan="2"><i>Total pembayaran pesangon</i></th>
											<td>:</td>
											<td><input class="form-control" name="total_severance" type="text" id="total_severance" readonly></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="mb-3">
								<label class="small mb-1">Periode pembayaran</label>
								<input type="month" class="form-control" name="payroll_period" id="" required>
							</div>
							<div class="mb-3">
								<label class="small mb-1">Tanggal PHK</label>
								<input type="date" class="form-control" name="termination_date" id="" required>
							</div>
							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>

						<form action="{{ route('severance.store') }}" method="post" id="form51">
							@csrf
							<input class="form-control nik_karyawan" name="nik_karyawan" type="hidden" readonly />
							<input class="form-control pasal" name="pasal" type="hidden" readonly />
							<input class="form-control" type="hidden" name="net_salary" id="net_salary">
							<div class="table-responsive">
								<table class="table table-hover mb-0">
									<tbody>
										<tr>
											<th scope="row">Serevance payment</th>
											<td>Number severance</td>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="bil_severance" id="bil_severance51" value="0.25" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Net salary</td>
											<td>:</td>
											<td>
												<input class="form-control net_salary" type="text" name="net_salary" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<th>Subtotal severance payment</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="subtotal_severance" id="subtotal_severance51" readonly>
											</td>
										</tr>
										<tr>
											<th scope="row">Reimbursement of rights</th>
											<td>:</td>
										</tr>
										<tr>
											<th>a. Annual leave</th>
											<td>Remaining leave</td>
											<td>:</td>
											<td>
												<div class="mb-2">
													<input class="form-control remaining_leave" type="text" name="remaining_leave" readonly>
												</div>
												<div class="mb-2">

												</div>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Net salary</td>
											<td>:</td>
											<td>
												<input class="form-control net_salary" type="text" name="net_salary" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Number annual leave</td>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="bil_annual" value="25" id="bil_annual51" readonly>
											</td>
										</tr>
										<tr>
											<td></td>
											<th>Subtotal annual leave</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="subtotal_annual" id="subtotal_annual51" readonly>
											</td>
										</tr>
										<tr>
											<th colspan="2">b. Return cost</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="return_cost" id="return_cost51">
											</td>
										</tr>
										<tr>
											<th colspan="2"><i>Total severance payment</i></th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="total_severance" id="total_severance51" readonly>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="payroll_period">
							</div>
							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="termination_date">
							</div>
							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>

						<form action="{{ route('severance.store') }}" method="post" id="form16">
							@csrf
							<input class="form-control nik_karyawan" name="nik_karyawan" type="hidden" readonly />
							<input class="form-control pasal" name="pasal" type="hidden" readonly />
							<input class="form-control" type="hidden" name="net_salary" id="net_salary">
							<div class="table-responsive">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<th scope="row">Kompensasi</th>
											<td>Years of service (Month)</td>
											<td>:</td>
											<td>
												<input class="form-control service_month" type="text" name="service_year" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Net salary</td>
											<td>:</td>
											<td>
												<input class="form-control net_salary" name="net_salary" type="text" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Numbers compensation</td>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="bil_compensation" id="bil_compensation" value="12" readonly>
											</td>
										</tr>
										<tr>
											<th colspan="2">Total compensation</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="total_severance" id="total_severance16" readonly>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="payroll_period">
							</div>
							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="termination_date">
							</div>
							<hr class="my-4" />
							<div class="d-flex justify-content-between">
								<a href="{{ url()->previous() }}" class="btn btn-light" type="button">Back</a>
								<button class="btn btn-primary" type="submit">Submit</button>
							</div>
						</form>

						<form action="{{ route('severance.store') }}" method="post" id="form522">
							@csrf
							<input class="form-control nik_karyawan" name="nik_karyawan" type="hidden" readonly />
							<input class="form-control pasal" name="pasal" type="hidden" readonly />
							<input class="form-control" type="hidden" name="net_salary" id="net_salary">
							<div class="table-responsive">
								<table class="table table-borderless mb-0">
									<tbody>
										<tr>
											<th scope="row">Serevance pay</th>
											<td>Constant number</td>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="bil_severance" id="bil_severance522" value="0.25" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Net salary</td>
											<td>:</td>
											<td>
												<input class="form-control net_salary" type="text" name="net_salary" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<th>Subtotal serevance pay</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="subtotal_severance" id="subtotal_severance522" readonly>
											</td>
										</tr>
										<tr>
											<th colspan="2" scope="row">Reimbursement of rights</th>
											<td>:</td>
											<td></td>
										</tr>
										<tr>
											<th>a. Annual leave</th>
											<td>Remaining leave</td>
											<td>:</td>
											<td>
												<input class="form-control remaining_leave" type="text" name="remaining_leave" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Net salary</td>
											<td>:</td>
											<td>
												<input class="form-control net_salary" type="text" name="net_salary" readonly>
											</td>
										</tr>
										<tr>
											<th></th>
											<td>Constant number</td>
											<td>:</td>
											<td>
												<input class="form-control bil_annual" type="text" name="bil_annual" value="25" readonly>
											</td>
										</tr>
										<tr>
											<th colspan="2">Subtotal annual leave</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="subtotal_annual" id="subtotal_annual522" readonly>
											</td>
										</tr>
										<tr>
											<th colspan="2">b. Return cost</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="return_cost" id="return_cost522">
											</td>
										</tr>
										<tr>
											<th colspan="2">Total severance pay</th>
											<td>:</td>
											<td>
												<input class="form-control" type="text" name="total_severance" id="total_severance522" readonly>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="mb-3">
								<label class="small mb-1">Payroll period</label>
								<input type="month" class="form-control" name="payroll_period">
							</div>

							<div class="mb-3">
								<label class="small mb-1">Termnination date</label>
								<input type="date" class="form-control" name="termination_date">
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
					$('.pasal').val(this.value);
				} else {
					$("#form521").slideUp("fast");
				}
				if ($(this).val() === "52 ayat (2)") {
					$("#form522").slideDown("fast");
					$('.pasal').val(this.value);
				} else {
					$("#form522").slideUp("fast");
				}
				if ($(this).val() === "51") {
					$("#form51").slideDown("fast");
					$('.pasal').val(this.value);
				} else {
					$("#form51").slideUp("fast");
				}
				if ($(this).val() === "40") {
					$("#form40").slideDown("fast");
					$('.pasal').val(this.value);
				} else {
					$("#form40").slideUp("fast");
				}
				if ($(this).val() === "16") {
					$("#form16").slideDown("fast");
					$('.pasal').val(this.value);
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
								$('.nik_karyawan').val(data.nik);
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
								$('#level_sp').val(data.level_sp);
								$('#kelurahan').val(data.kelurahan);
								$('#alamat').val(data.alamat_ktp);
								$('#net_salary').val(data.tot_diterima);
								$('#basic_salary').val(data.gaji_pokok);
								$('.remaining_leave').val(data.sisa_cuti);
								$('.service_year').val(data.service_year);
								$('#service_month_award').val(checkMonthYear(data.service_month));
								$('.service_month').val(data.service_month);
								$('.basic_salary').val(formatRupiah(data.gaji_pokok, "Rp"));
								$('.net_salary').val(formatRupiah(data.tot_diterima, "Rp"));
							}
						}
					});
				}
			});

			$("#list-pasal").on('change', function() {
				// Perhitungan pesangon pasal 52 ayat 1
				var subtotal_severance521 = (parseFloat($('#bil_severance521').val()) * parseInt($('.service_year').val())) * parseInt($('#net_salary').val());
				$('#subtotal_severance521').val(subtotal_severance521);

				var subtotal_severance_rp = document.getElementById("subtotal_severance521").value;

				if (subtotal_severance_rp > 0) {
					$('#subtotal_severance521').val(formatRupiah(subtotal_severance_rp, "Rp"));
				}

				var subtotal_award = parseInt($('#service_month_award').val()) * parseInt($('#net_salary').val());
				$('#subtotal_award').val(subtotal_award);

				var subtotal_award_rp = document.getElementById("subtotal_award").value;

				if (subtotal_award_rp > 0) {
					$('#subtotal_award').val(formatRupiah(subtotal_award_rp, "Rp"));
				}

				var subtotal_annual = (parseFloat($('.remaining_leave').val()) * parseInt($('#basic_salary').val())) / parseInt($('#bil_annual').val());
				$('#subtotal_annual').val(subtotal_annual);

				var subtotal_annual_rp = document.getElementById("subtotal_annual").value;

				if (subtotal_annual_rp > 0) {
					$('#subtotal_annual').val(formatRupiah(subtotal_annual_rp, "Rp"));
				}
				// Perhitungan pesangon pasal 52 ayat 1 end

				// Perhitunan pesangon pasal 51 start
				var subtotal_severance51 = (parseFloat($('#bil_severance51').val()) * parseInt($('#net_salary').val()));
				$('#subtotal_severance51').val(subtotal_severance51);

				var subtotal_severance_rp51 = document.getElementById("subtotal_severance51").value;

				if (subtotal_severance_rp51 > 0) {
					$('#subtotal_severance51').val(formatRupiah(subtotal_severance_rp51, "Rp"));
				}

				var subtotal_annual51 = (parseFloat($('.remaining_leave').val()) * parseInt($('#net_salary').val())) / parseInt($('#bil_annual51').val());
				$('#subtotal_annual51').val(subtotal_annual51);

				var subtotal_annual_rp51 = document.getElementById("subtotal_annual51").value;

				if (subtotal_annual_rp51 > 0) {
					$('#subtotal_annual51').val(formatRupiah(subtotal_annual_rp51, "Rp"));
				}
				// Perhitungan pesangon pasal 51 end

				// Perhitungan pesangon pasal 16
				if ($('#list-pasal').val() === '16') {
					var total_severance16 = (parseInt($('.service_month').val()) * parseInt($('#net_salary').val())) / parseInt($('#bil_compensation').val());
					$('#total_severance16').val(hapusAngkaSetelahTitik(total_severance16));

					var total_severance16_rp = document.getElementById("total_severance16").value;

					if (total_severance16_rp > 0) {
						$('#total_severance16').val(formatRupiah(total_severance16_rp, "Rp"));
					}
				}
				// Perhitungan pesangon pasal 16 end

				/* Perhitunganb pesangon pasal 52 ayat 2 */
				var subtotal_severance522 = parseFloat($('#bil_severance522').val()) * parseInt($('#net_salary').val());
				$('#subtotal_severance522').val(subtotal_severance522);

				var subtotal_severance522_rp = document.getElementById("subtotal_severance522").value;

				if (subtotal_severance522_rp > 0) {
					$('#subtotal_severance522').val(formatRupiah(subtotal_severance522_rp, "Rp. "));
				}

				var subtotal_annual522 = (parseFloat($('.remaining_leave').val()) * parseInt($('#net_salary').val())) / parseInt($('.bil_annual').val());
				$('#subtotal_annual522').val(subtotal_annual522);

				var subtotal_annual522_rp = document.getElementById("subtotal_annual522").value;

				if (subtotal_annual522_rp > 0) {
					$('#subtotal_annual522').val(formatRupiah(subtotal_annual522_rp, "Rp"));
				}
				/* Perhitunganb pesangon pasal 52 ayat 2 end */
			});

			// Keyup pesangon 52 ayat 1
			var return_cost521 = document.getElementById("return_cost521");
			return_cost521.addEventListener("keyup", function(e) {

				// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
				return_cost521.value = formatRupiah(this.value, "Rp");

				replace = this.value.replace("Rp", "");
				checked = replace.split('.').join("");
				cost = checked;

				var subtotal_severance521 = (parseFloat($('#bil_severance521').val()) * parseInt($('.service_year').val())) * parseInt($('#net_salary').val());
				var subtotal_award = parseInt($('#service_month_award').val()) * parseInt($('#net_salary').val());
				var subtotal_annual = (parseFloat($('.remaining_leave').val()) * parseInt($('#basic_salary').val())) / parseInt($('#bil_annual').val());

				var total_severance = parseInt(subtotal_severance521) + parseInt(subtotal_award) + parseInt(subtotal_annual) + parseInt(cost);
				$('#total_severance').val(total_severance);

				var total_severance_rp = document.getElementById("total_severance").value;

				if (total_severance_rp > 0) {
					$('#total_severance').val(formatRupiah(total_severance_rp, "Rp"));
				}
			});
			// end

			// Keyup pesangon 51
			var return_cost51 = document.getElementById("return_cost51");
			return_cost51.addEventListener("keyup", function(e) {

				// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
				return_cost51.value = formatRupiah(this.value, "Rp");

				replace = this.value.replace("Rp", "");
				checked = replace.split('.').join("");
				cost = checked;

				var subtotal_severance51 = (parseFloat($('#bil_severance51').val()) * parseInt($('#net_salary').val()));
				var subtotal_annual51 = (parseFloat($('.remaining_leave').val()) * parseInt($('#net_salary').val())) / parseInt($('#bil_annual51').val());

				var total_severance51 = parseInt(subtotal_severance51) + parseInt(subtotal_annual51) + parseInt(cost);
				$('#total_severance51').val(total_severance51);

				var total_severance_rp51 = document.getElementById("total_severance51").value;

				if (total_severance_rp51 > 0) {
					$('#total_severance51').val(formatRupiah(total_severance_rp51, "Rp"));
				}
			});
			// end

			// Keyup pesangon 52 ayat 2
			var return_cost522 = document.getElementById("return_cost522");
			return_cost522.addEventListener("keyup", function(e) {

				// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
				return_cost522.value = formatRupiah(this.value, "Rp");

				replace = this.value.replace("Rp", "");
				checked = replace.split('.').join("");
				cost = checked;

				var subtotal_severance522 = parseFloat($('#bil_severance522').val()) * parseInt($('#net_salary').val());
				var subtotal_annual522 = (parseFloat($('.remaining_leave').val()) * parseInt($('#net_salary').val())) / parseInt($('.bil_annual').val());

				var total_severance522 = parseInt(subtotal_severance522) + parseInt(subtotal_annual522) + parseInt(cost);
				$('#total_severance522').val(total_severance522);

				var total_severance522_rp = document.getElementById("total_severance522").value;

				if (total_severance522_rp > 0) {
					$('#total_severance522').val(formatRupiah(total_severance522_rp, "Rp"));
				}
			});
			// end

			/* Fungsi check month */
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

			function hapusAngkaSetelahTitik(angka) {
				var string = angka.toString();
				var result = string.split('.')[0];
				return result;
			}

			/* Fungsi formatRupiah */
			function formatRupiah(angka, prefix) {
				// Hapus semua karakter yang bukan angka
				var number_string = angka.replace(/[^\d]/g, "").toString();

				// Pecah string menjadi bagian integer dan desimal (abaikan desimal)
				var sisa = number_string.length % 3;
				var rupiah = number_string.substr(0, sisa);
				var ribuan = number_string.substr(sisa).match(/\d{3}/gi);

				// Tambahkan titik sebagai pemisah ribuan
				if (ribuan) {
					var separator = sisa ? "." : "";
					rupiah += separator + ribuan.join(".");
				}

				// Kembalikan hasil dengan atau tanpa prefix "Rp"
				return prefix == undefined ? rupiah : (rupiah ? prefix + rupiah : "");
			}
		});
	</script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
		$('.search').select2({
			width: 'resolve',
			theme: 'classic',
			placeholder: 'Cari karyawan...',
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
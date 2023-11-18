<x-app-layout title="Cuti Roster">
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
							<div class="page-header-icon"><i data-feather="archive"></i></div>
							Cuti Roster
						</h1>
					</div>
					<div class="col-12 col-xl-auto mb-3">
						<a class="btn btn-sm btn-light text-blue" href="/admin/roster">
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
		<div class="card">
			<div class="card-body">
				<div class="row justify-content-center">
					<div class="col-xxl-10 col-xl-8">
						<h3 class="text-primary text-center">Formulir Cuti Roster</h3>
						<h5 class="card-title mb-4">
							<img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;" class="">
						</h5>
						<div class="table-responsive col-lg-12">
							<table class="table table-borderless mb-2">
								<thead class="border-bottom">
									<tr class="small text-uppercase text-muted">
										<th scope="col">RENCANA PADA MASA PERIODE ISTIRAHAT ROSTER 休假期的计划</th>
									</tr>
								</thead>
							</table>
						</div>
						<div class="row">
							<div class="table-responsive col-lg-12">
								<table class="table table-borderless mb-2">
									<tbody class="border-bottom">
										<tr>
											<td>
												Tidak ada pilihan
											</td>
											<td>
												<input class="form-check-input tipe-rencana" type="radio" name="tipe_rencana" value="0" checked>
											</td>
										</tr>
										<tr>
											<td>
												Cuti
											</td>
											<td>
												<input class="form-check-input tipe-rencana" type="radio" name="tipe_rencana" value="1">
											</td>
										</tr>
										<tr>
											<td>
												Bekerja
											</td>
											<td>
												<input class="form-check-input tipe-rencana" type="radio" name="tipe_rencana" value="2">
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

						<form id="form-cuti" action="{{ route('admindept.cuti.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div style="display: block;">
								<div class="row gx-3 mb-2">
									<div class="col-md-12 mb-2">
										<label class="small mb-2">Alasan</label>
										<textarea class="form-control" name="alasan_pilihan" id="" cols="30" rows="10"></textarea>
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">Nama</label>
										<input class="form-control" type="text" name="nama" value="{{ $data->nama_karyawan }}" readonly />
										<input class="form-control" type="hidden" name="pengingat_id" value="{{ $data->id }}" readonly />
										<input class="form-control tipe_pilihan" type="hidden" name="tipe_pilihan" readonly />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Departemen</label>
										<input class="form-control" name="departemen" type="text" value="{{ $data->departemen ?? '' }}" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">NIK</label>
										<input class="form-control nik_karyawan" name="nik_karyawan" type="text" value="{{ $data->nik }}" readonly />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Posisi</label>
										<input class="form-control" name="posisi" type="text" value="{{ $data->posisi }}" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">No HP</label>
										<input class="form-control" name="no_telp" type="number" value="{{ $data->no_telp }}" readonly />
									</div>
									<div class="col-md-6 mb-2">
										<label class="small mb-2">Divisi</label>
										<input class="form-control" name="divisi" type="text" value="{{ $data->nama_divisi ?? '' }}" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Email</label>
										<input class="form-control" name="email" type="email" />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Tanggal Pengajuan</label>
										<input class="form-control date" name="tanggal_pengajuan" type="text" placeholder="DD-MM-YYYY" required />
									</div>
								</div>
							</div>

							<div class="table-responsive col-lg-12">
								<table class="table table-borderless mb-2">
									<thead class="border-bottom">
										<tr class="small text-uppercase text-muted">
											<th scope="col">PERIODE ROSTER SAAT INI 目前休假明细</th>
										</tr>
									</thead>
									<tbody>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">Tanggal Periode Kerja Roster 工作日期</div>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="periode_awal" type="text" placeholder="DD-MM-YYYY" required />
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="periode_akhir" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">I</div>
											</td>
											<td>
												<select name="satu" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_satu" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">II</div>
											</td>
											<td>
												<select name="dua" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_dua" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">III</div>
											</td>
											<td>
												<select name="tiga" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_tiga" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">IV</div>
											</td>
											<td>
												<select name="empat" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_empat" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">V</div>
											</td>
											<td>
												<select name="lima" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_lima" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="row">
								<div class="table-responsive col-lg-6">
									<table class="table table-borderless mb-2">
										<thead class="border-bottom">
											<tr class="small text-uppercase text-muted">
												<th scope="col">Keberangkatan</th>
											</tr>
										</thead>
										<tbody>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Cuti roster</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_mulai_cuti" type="text" placeholder="DD-MM-YYYY" required />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Cuti tahunan</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_mulai_cuti_tahunan" type="text" placeholder="DD-MM-YYYY" />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Off</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_mulai_off" type="text" placeholder="DD-MM-YYYY" />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Tanggal keberangkatan</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tanggal_keberangkatan" type="text" placeholder="DD-MM-YYYY" required />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Waktu keberangkatan</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control" name="jam_keberangkatan" type="text" maxlength="5" placeholder="07:00" required />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Dari</div>
												</td>
												<td class="text-end fw-bold">
													<select class="form-select search-kota" name="kota_awal_keberangkatan" required></select>
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Tujuan</div>
												</td>
												<td class="text-end fw-bold">
													<select class="form-select search-kota" name="kota_tujuan_keberangkatan" required></select>
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Catatan penting</div>
												</td>
												<td class="text-end fw-bold">
													<textarea name="catatan_penting_keberangkatan" class="form-control" id="" cols="30" rows="5"></textarea>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="table-responsive col-lg-6">
									<table class="table table-borderless mb-0">
										<thead class="border-bottom">
											<tr class="small text-uppercase text-muted">
												<th scope="col">Kepulangan</th>
											</tr>
										</thead>
										<tbody>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Cuti roster berakhir</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_mulai_cuti_berakhir" type="text" placeholder="DD-MM-YYYY" required />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Cuti tahunan berakhir</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_mulai_cuti_tahunan_berakhir" type="text" placeholder="DD-MM-YYYY" />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Off berakhir</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_mulai_off_berakhir" type="text" placeholder="DD-MM-YYYY" />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Tanggal kepulangan</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control date" name="tgl_kepulangan" type="text" placeholder="DD-MM-YYYY" required />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Waktu kepulangan</div>
												</td>
												<td class="text-end fw-bold">
													<input class="form-control" name="jam_kepulangan" type="text" maxlength="5" placeholder="07:00" required />
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Dari</div>
												</td>
												<td class="text-end fw-bold">
													<select class="form-select search-kota" name="kota_awal_kepulangan" required></select>
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Tujuan</div>
												</td>
												<td class="text-end fw-bold">
													<select class="form-select search-kota" name="kota_tujuan_kepulangan" required></select>
												</td>
											</tr>
											<tr class="border-bottom">
												<td>
													<div class="fw-bold">Catatan penting</div>
												</td>
												<td class="text-end fw-bold">
													<textarea name="catatan_penting_kepulangan" class="form-control" id="" cols="30" rows="5"></textarea>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="mb-3">
								<label for="" class="mb-2">Berkas pendukung</label>
								<input type="file" name="berkas_cuti" class="form-control">
							</div>
							<hr class="my-4" />
							<div class="d-grid">
								<button class="btn btn-primary" type="submit">Simpan</button>
							</div>
						</form>

						<form id="form-kerja" action="{{ route('admindept.cuti.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row gx-3 mb-2">
								<div class="col-md-12 mb-2">
									<label class="small mb-2">Alasan</label>
									<textarea class="form-control" name="alasan_pilihan" id="" cols="30" rows="10"></textarea>
								</div>
							</div>
							<div style="display: block;">
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">Nama</label>
										<input class="form-control" type="text" name="nama" value="{{ $data->nama_karyawan }}" readonly />
										<input class="form-control" type="hidden" name="pengingat_id" value="{{ $data->id }}" readonly />
										<input class="form-control tipe_pilihan" type="hidden" name="tipe_pilihan" readonly />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Departemen</label>
										<input class="form-control" name="departemen" type="text" value="{{ $data->departemen ?? '' }}" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">NIK</label>
										<input class="form-control nik_karyawan" name="nik_karyawan" type="text" value="{{ $data->nik }}" readonly />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Posisi</label>
										<input class="form-control" name="posisi" type="text" value="{{ $data->posisi }}" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6 mb-2">
										<label class="small mb-2">No HP</label>
										<input class="form-control" name="no_telp" type="number" value="{{ $data->no_telp }}" readonly />
									</div>
									<div class="col-md-6 mb-2">
										<label class="small mb-2">Divisi</label>
										<input class="form-control" name="divisi" type="text" value="{{ $data->nama_divisi ?? '' }}" readonly />
									</div>
								</div>
								<div class="row gx-3 mb-2">
									<div class="col-md-6">
										<label class="small mb-2">Email</label>
										<input class="form-control" name="email" type="email" />
									</div>
									<div class="col-md-6">
										<label class="small mb-2">Tanggal Pengajuan</label>
										<input class="form-control date" name="tanggal_pengajuan" type="text" placeholder="DD-MM-YYYY" required />
									</div>
								</div>
							</div>
							<div class="table-responsive col-lg-12">
								<table class="table table-borderless mb-2">
									<thead class="border-bottom">
										<tr class="small text-uppercase text-muted">
											<th scope="col">PERIODE ROSTER SAAT INI 目前休假明细</th>
										</tr>
									</thead>
									<tbody>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">Tanggal Periode Kerja Roster 工作日期</div>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="periode_awal" type="text" placeholder="DD-MM-YYYY" required />
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="periode_akhir" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">I</div>
											</td>
											<td>
												<select name="satu" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_satu" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">II</div>
											</td>
											<td>
												<select name="dua" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_dua" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">III</div>
											</td>
											<td>
												<select name="tiga" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_tiga" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">IV</div>
											</td>
											<td>
												<select name="empat" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_empat" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">V</div>
											</td>
											<td>
												<select name="lima" class="form-select" id="">
													<option value="OFF">OFF</option>
													<option value="BEKERJA">BEKERJA</option>
												</select>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tanggal_lima" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="table-responsive col-lg-12">
								<table class="table table-borderless mb-2">
									<thead class="border-bottom">
										<tr class="small text-uppercase text-muted">
											<th scope="col">Tanggal Periode Kerja Roster 工作日期</th>
										</tr>
									</thead>
									<tbody>
										<tr class="border-bottom">
											<td>
												<div class="fw-bold">Tanggal Periode Kerja Roster 工作日期</div>
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tgl_awal_kerja" type="text" placeholder="DD-MM-YYYY" required />
											</td>
											<td class="text-end fw-bold">
												<input class="form-control date" name="tgl_akhir_kerja" type="text" placeholder="DD-MM-YYYY" required />
											</td>
										</tr>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="mb-3">
								<label for="" class="mb-2">Berkas pendukung</label>
								<input type="file" name="berkas_cuti" class="form-control">
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
	</script>
	<script>
		$(document).ready(function() {
			// Menghilangkan form-input ketika pertama kali dijalankan

			$("#form-cuti").css("display", "none");
			$("#form-kerja").css("display", "none");

			// Menghilangkan form-input ketika pertama kali dijalankan end

			$('.tipe-rencana').change(function() {
				if ($(this).val() === "1") {
					$("#form-cuti").slideDown("fast"); //Efek Slide Down (Menampilkan Form Input)
					$('.tipe_pilihan').val(this.value);
				} else {
					$("#form-cuti").slideUp("fast");
				}
				if ($(this).val() === "2") {
					$("#form-kerja").slideDown("fast");
					$('.tipe_pilihan').val(this.value);
				} else {
					$("#form-kerja").slideUp("fast");
				}
			})
		});
	</script>
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
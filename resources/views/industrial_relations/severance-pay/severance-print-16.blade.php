<!DOCTYPE html>
<html lang="en">

<head>
	<!-- <meta charset="utf-8" /> -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<meta name="description" content="" />
	<meta name="author" content="" />
	<title>Collective agreement</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<style>
		@font-face {
			font-family: 'Times New Roman';
			font-style: normal;
			font-weight: 600;
			src: url('https://eclecticgeek.com/dompdf/fonts/cjk/fireflysung.ttf') format('truetype');
		}

		* {
			font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif, sans-serif;
			font-size: 12px;
			font-weight: 600;
		}
		/* Thick red border */
		hr.new4 {
			border: 0.2px solid black;
		}

		.justify {
			text-align: justify;
		}
	</style>
</head>

<body class="nav-fixed">
	<div id="layoutSidenav">
		<main>
			<!-- Main page content-->
			<div class="container-xl px-1">
				<div class="text-end mb-2">
					<img src="{{ public_path('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 40px;" alt=""><br>
				</div>
				<div class="text-center">
					<h4 class="fw-bold">PERJANJIAN BERSAMA</h4>
				</div>
				<div class="d-flex justify-content-between">
					Pada hari ini sabtu tanggal empat belas bulan oktober tahun dua ribu dua puluh tiga kami yang bertanda tangan dibawah ini :
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table style="width: 100%;">
							<tbody>
								<tr>
									<td style="width: 5%">1.</td>
									<td style="width: 12%">Nama</td>
									<td style="width: 5%">:</td>
									<td>AHMAD SAEKUZEN</td>
								</tr>
								<tr>
									<td></td>
									<td>Jabatan</td>
									<td>:</td>
									<td>HRD MANAGER</td>
								</tr>
								<tr>
									<td></td>
									<td>Perusahaan</td>
									<td>:</td>
									<td>PT. VDNI</td>
								</tr>
								<tr>
									<td></td>
									<td>Alamat</td>
									<td>:</td>
									<td>Sampara/Morosi, Kec. Bondoala, Kabupaten Konawe, Sulawesi Tenggara</td>
								</tr>
								<tr>
									<td></td>
									<td colspan="3"><b>Yang selanjutnya disebut Pihak Pertama (Pengusaha)</b></td>
								</tr>
							</tbody>
						</table>
						<table style="width: 100%;">
							<tbody>
								<tr>
									<td style="width: 5%">2.</td>
									<td style="width: 12%">Nama</td>
									<td style="width: 5%">:</td>
									<td>{{ $data->employee->nama_karyawan }}</td>
								</tr>
								<tr>
									<td></td>
									<td>Jabatan</td>
									<td>:</td>
									<td>{{ $data->employee->posisi }}</td>
								</tr>
								<tr>
									<td></td>
									<td>NIK</td>
									<td>:</td>
									<td>{{ $data->nik_karyawan }}</td>
								</tr>
								<tr>
									<td></td>
									<td>Alamat</td>
									<td>:</td>
									<td>{{ $data->employee->alamat_ktp }}</td>
								</tr>
								<tr>
									<td></td>
									<td colspan="3"><b>Yang selanjutnya disebut Pihak Pertama (Pekerja)</b></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="d-flex justify-content-between">
					Pihak Pertama dan Pihak Kedua mengadakan perundingan Bipartit dan telah tercapai kesepatan sebagai berikut :
				</div>
				<table style="width: 100%;">
					<tr>
						<td style="width: 8%;"></td>
						<td class="align-top" style="width: 5%">1.</td>
						<td class="justify">
							Bahwa sehubungan dengan terbitnya {{ $data->spreport->level_sp ?? 'SP tidak ditemukan' }} maka pihak manajemen melakukan pemutusan hubungan kerja kepada Pihak Kedua pertanggal {{ date('d F Y', strtotime($data->termination_date)) }}.
						</td>
					</tr>
					<tr>
						<td style="width: 6;"></td>
						<td class="align-top" style="width: 5%">2.</td>
						<td class="justify">
							Bahwa dengan ini kedua belah pihak <b>BERSEPAKAT</b> bahwa Pihak Kedua berakhir hubungan kerjanya sebagai karyawan PT. VDNI terhitung sejak tanggal {{ date('d F Y', strtotime($data->termination_date)) }}.
						</td>
					</tr>
					<tr>
						<td style="width: 6;"></td>
						<td class="align-top" style="width: 5%">3.</td>
						<td class="justify">
							Bahwa berdasarkan Pemutusan Hubungan Kerja, pihak pengusaha memberikan hak-hak kepada pihak Pekerja sebagaimana ketentuan Pasal {{ $data->pasal }} Peraturan Pemerintah Nomor 35 Tahun 2021 tentang PKWTT, Alih daya, WKWI, dan PHK dengan uraian sebagai berikut :
						</td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="width: 3%;"></td>
						<td style="width: 3%;">-</td>
						<td style="width: 12%;">Kompensasi</td>
						<td style="width: 15%;">({{ $data->service_year }} x {{$data->net_salary}},-) / {{ $data->bil_compensation }}</td>
						<td style="width: 3%;">:</td>
						<td style="width: 10%;">{{ $data->total_severance }}</td>
					</tr>
					<tr>
						<td style="width: 3%;"></td>
						<td style="width: 3%;"></td>
						<td style="width: 12%;"></td>
						<td style="width: 15%;"></td>
						<td style="width: 3%;"></td>
						<td style="width: 10%;">
							<hr class="new4" />
						</td>
					</tr>
					<tr>
						<th colspan="4" class="text-center"><b>Jumlah</b></th>
						<td>:</td>
						<td><b>{{ $data->total_severance }}</b></td>
					</tr>
				</table>
				<table style="width: 100%;">
					<tr>
						<td style="width: 8%"></td>
						<td class="align-top" style="width: 4%">4.</td>
						<td class="justify">
							Bahwa terkait dengan pengakhiran hubungan kerja pihak kedua efektif sejak tanggal {{date('d F Y', strtotime($data->termination_date))}} Pihak pertama sepakat untuk memberikan hak-haknya kepada Pihak Kedua sebesar <b>{{$data->total_severance}},-</b>.
						</td>
					</tr>
					<tr>
						<td style="width: 6"></td>
						<td class="align-top" style="width: 4%">5.</td>
						<td class="justify">
							Bahwa hak-hak yang dibayarkan oleh Pihak Pertama kepada Pihak Kedua sebesar <b>{{$data->total_severance}},-</b> dengan ketentuan Pasal {{$data->pasal}} Peraturan Pemerintah Nomor 35 Tahun 2021 dan telah disepakati akan dibayarkan melalui nomor rekening yang tecatat dipayroll dan pembayaran akan dibayarkan dalam periode penggajian bulan {{date('F Y', strtotime($data->payroll_period))}}
						</td>
					</tr>
					<tr>
						<td style="width: 6"></td>
						<td class="align-top" style="width: 4%">6.</td>
						<td class="justify">
							Bahwa Pihak Kedua menjamin tidak akan menuntut secara hukum baik perdata maupun pidana kepada Pihak Pertama sehubungan dengan Pemutusan Hubungan Kerja (PHK) pertanggal {{ date('d F Y', strtotime($data->termination_date)) }}.
						</td>
					</tr>
					<tr>
						<td style="width: 6"></td>
						<td class="align-top" style="width: 4%">7.</td>
						<td class="justify">
							Bahwa pihak kedua akan tetap mendukung jalannya proses investasi di wilayah konawe
						</td>
					</tr>
					<tr>
						<td style="width: 6"></td>
						<td class="align-top" style="width: 4%">8.</td>
						<td class="justify">
							Demikian <b>Perjanjian Bersama</b> ini dibuat dalam keadaan sadar tanpa ada paksaan dari pihak manapun, dan dilaksanakan dengan penuh rasa tanggung jawab yang didasari atas itikat baik oleh kedua belah pihak.
						</td>
					</tr>
				</table>
				<table style="text-align: center; width: 100%">
					<tr>
						<td style="width: 35%"><b>PIHAK PERTAMA</b></td>
						<br>
						<br>
						<br>
						<br>
						<br>
						<td><b>PIHAK KEDUA</b></td>
					</tr>
					<tr>
						<td><b>AHMAD SAEKUZEN</b></td>
						<br>
						<br>
						<br>
						<br>
						<br>
						<td><b>{{ $data->employee->nama_karyawan }}</b></td>
					</tr>
				</table>
		</main>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="js/scripts.js"></script>
</body>

</html>
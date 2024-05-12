<x-app-layout title="Pengingat">
	@push('styles')
	<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
	<link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
	<link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
	<link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
	<script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	@endpush

	<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
		<div class="container-fluid px-4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="bell"></i></div>
							Pengingat
						</h1>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Main page content-->
	<div class="container-fluid px-4">
		<x-message />
		<div class="row">
			<div class="col-lg-12 mb-2">
				<form action="/admin/roster" method="get">
					@csrf
					<div class="card">
						<div class="card-body" style="overflow-x: auto;">
							<select name="status_pengajuan" id="" class="form-select">
								<option value="" selected>-- Pilih status pengajuan --</option>
								<option value="Selesai">Selesai</option>
								<option value="Proses">Proses</option>
								<option value="Belum Pengajuan">Belum pengajuan</option>
								<option value="Jatuh Tempo">Jatuh tempo</option>
							</select>
							<div class="mt-2">
								<button class="btn btn-sm btn-light text-primary" type="submit">
									<i class="me-1" data-feather="search"></i>
									Filter
								</button>
								<a class="btn btn-sm btn-light text-primary" href="/roster/daftar-pengingat">
									<i class="me-1" data-feather="trash"></i>
									Bersihkan
								</a>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body" style="overflow-x: auto;">
						<table id="datatablesSimple" class="table table-hover">
							<thead>
								<tr>
									<th>No</th>
									<th>NIK</th>
									<th>Nama</th>
									<th>Pesan</th>
									<th>Tanggal cuti</th>
									<th>Periode</th>
									<th>Tahun</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								@foreach($datas as $data)
								@php
								$tahun = 0;
								$bulan = 0;
								$tgl_cuti = new DateTime($data->tanggal_cuti);
								$tgl_sekarang = new DateTime(today());
								$tgl_jt_tempo = $tgl_sekarang->diff($tgl_cuti)->days;

								if($tgl_sekarang->diff($tgl_cuti)->m > 0){
								$tahun = $tgl_sekarang->diff($tgl_cuti)->y;
								$bulan = $tgl_sekarang->diff($tgl_cuti)->m;
								}
								@endphp
								<tr>
									<td>{{ ++$no }}</td>
									<td>
										{{ $data->nik_karyawan }} <br>
										@if($data->status_pengajuan === NULL)
										<span class="badge bg-warning-soft text-warning">Belum pengajuan</span>
										@endif
										@if((strtolower($data->status_pengajuan) === 'proses') && ($tgl_jt_tempo > 0))
										<span class="badge bg-primary-soft text-primary">Proses</span>
										@endif
										@if(strtolower($data->status_pengajuan) == 'selesai' && $tgl_jt_tempo > 0)
										<span class="badge bg-success-soft text-success">Selesai</span>
										@endif
										@if($data->status_pengajuan == NULL || strtolower($data->status_pengajuan) && $tgl_jt_tempo > 0 && strtolower($data->status_pengajuan) != 'selesai')
										@if($tgl_jt_tempo >= 14 && $tahun > 0)
										<span class="badge bg-danger-soft text-danger">jatuh tempo {{ $tahun }} tahun {{ $bulan }} bulan</span>
										@endif
										@if($tgl_cuti < $tgl_sekarang && $tgl_jt_tempo < 365) <span class="badge bg-danger-soft text-danger">Jatuh tempo {{ $tgl_jt_tempo }} hari yang lalu</span>
											@endif
											@if($tgl_cuti > $tgl_sekarang)
											<span class="badge bg-info-soft text-info">Jatuh tempo {{ $tgl_jt_tempo }} hari lagi</span>
											@endif
											@endif
									</td>
									<td>{{ $data->karyawan->nama_karyawan ?? '' }}</td>
									<td>{{ $data->pesan }}</td>
									<td>{{ $data->tanggal_cuti }}</td>
									<td>Cuti Ke-{{ $data->periode_mingguan }}</td>
									<td>{{ $data->periode->awal_periode }} - {{ $data->periode->akhir_periode }}</td>
									<td>
										<div class="dropdown">
											<button class="btn btn-sm btn-primary dropdown-toggle" id="dropdownFadeIn" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Opsi</button>
											<div class="dropdown-menu animated--fade-in" aria-labelledby="dropdownFadeIn">
												<a href="{{route('admindept.formcuti', $data->nik_karyawan)}}" class="dropdown-item">Pengajuan</a>
											</div>
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	@push('scripts')
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/scripts.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
	<script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
	<script src="{{ asset('js/litepicker.js')}}"></script>
	<script src="{{ asset('js/app.js')}}"></script>
	@endpush
</x-app-layout>
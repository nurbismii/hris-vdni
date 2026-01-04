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
	<!-- Select2 -->

	<style>
		hr.new4 {
			border: 0.2px solid black;
		}

		.justify {
			text-align: justify;
		}

		table,
		th,
		td {
			border: 1px solid;
		}
	</style>
	@endpush

	<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
		<div class="container-xl px-4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="archive"></i></div>
							Cuti roster detail
						</h1>
					</div>
					<div class="col-12 col-xl-auto mb-3">
						<a class="btn btn-sm btn-light text-blue" href="/ess/status/permohonan">
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
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-body" style="overflow-x:auto;">
						<h3 class="text-primary text-center">Formulir cuti roster</h3>
						<h5 class="card-title mb-2">
							<img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" style="height: 30px;">
						</h5>
						<div class="table-responsive">
							<table style="width: 100%;">
								<tbody>
									<tr>
										<th colspan="10" class="font-weight-bold">I. DATA KARYAWAN 个人信息</th>
									</tr>
									<tr>
										<td>Nama 姓名</td>
										<td colspan="2">{{ $cuti->nama_karyawan }}</td>
										<td>Tanggal Pengajuan 申请日期</td>
										<td colspan="6">{{ tgl_indo($cuti->tanggal_pengajuan) }}</td>
									</tr>
									<tr>
										<td>NIK工号</td>
										<td colspan="2">{{ $cuti->nik }}</td>
										<td>Nomor HP 手机号</td>
										<td colspan="6">{{ $cuti->no_telp }}</td>
									</tr>
									<tr>
										<td>Posisi 岗位</td>
										<td colspan="2">{{ $cuti->posisi }}</td>
										<td>Email 邮件地址</td>
										<td colspan="6">{{ $cuti->email ?? '' }}</td>
									</tr>
									<tr>
										<th class="text-center" colspan="10">PERIODE ROSTER SAAT INI 目前休假明细</th>
									</tr>
									<tr>
										<th class="text-center" colspan="10">Tanggal Periode Kerja Roster <br> 工作日期</th>
									</tr>
									@if($cuti->periode_awal > "2016-04-01")
									<tr>
										<th class="text-center" colspan="10">{{ tgl_indo($cuti->periode_awal) }} - {{ tgl_indo($cuti->periode_akhir) }} </th>
									</tr>
									@else
									<tr>
										<th class="text-center" colspan="10">-</th>
									</tr>
									@endif
									<tr class="text-center">
										<th style="width: 20%;" rowspan="3">OFF 休息日</th>
										<td colspan="1" style="width: 16%;">I</td>
										<td colspan="1" style="width: 16%;">II</td>
										<td colspan="1" style="width: 16%;">III</td>
										<td style="width: 9rem;">IV</td>
										<td style="width: 80rem;" colspan="5">V</td>
									</tr>
									<tr class="text-center">
										<td colspan="1">{{ $cuti->satu }}</td>
										<td colspan="1">{{ $cuti->dua }}</td>
										<td colspan="1">{{ $cuti->tiga }}</td>
										<td style="width: 20%;">{{ $cuti->empat }}</td>
										<td colspan="5">{{ $cuti->lima }}</td>
									</tr>
									<tr class="text-center">
										<td colspan="1">{{ $cuti->tanggal_satu }}</td>
										<td colspan="1">{{ $cuti->tanggal_dua }}</td>
										<td colspan="1">{{ $cuti->tanggal_tiga }}</td>
										<td>{{ $cuti->tanggal_empat }}</td>
										<td colspan="5">{{ $cuti->tanggal_lima }}</td>
									</tr>
									<tr>
										<th class="text-center" colspan="10">RENCANA PADA MASA PERIODE ISTIRAHAT ROSTER 休假期的计划</th>
									</tr>
									<tr class="text-center">
										<td colspan="1">Jenis Pilihan 选择</td>
										<td colspan="2">Pilihan (√) 选择栏</td>
										<td colspan="7">Alasan 原因</td>
									</tr>
									<tr class="text-center">
										<td colspan="1">Cuti 轮休假</td>
										<td colspan="2">
											@if($cuti->tipe_rencana == '1')
											&radic;
											@endif
										</td>
										<td colspan="7">
											@if($cuti->tipe_rencana == '1')
											{{$cuti->alasan}}
											@endif
										</td>
									</tr>
									<tr class="text-center">
										<td colspan="1">Bekerja 工作</td>
										<td colspan="2">
											@if($cuti->tipe_rencana == '2')
											&radic;
											@endif
										</td>
										<td colspan="7">
											@if($cuti->tipe_rencana == '2')
											{{$cuti->alasan}}
											@endif
										</td>
									</tr>
									<tr>
										<th colspan="10">II. a @if($cuti->tipe_rencana == '1') &radic; @endif PENGAJUAN CUTI 申请休假</th>
									</tr>
									<tr class="text-center">
										<td>Jenis Cuti 休假类型</td>
										<td colspan="4">Periode Tanggal Cuti 休假日期</td>
										<td colspan="5">Total Hari Cuti 休假总数（天）</td>
									</tr>
									<tr class="text-center">
										<td>Cuti Roster 轮休假</td>
										@if($cuti->tgl_mulai_cuti != NULL && $cuti->tgl_mulai_cuti > '2016-04-01')
										<td colspan="4">{{ tgl_indo($cuti->tgl_mulai_cuti) }} - {{ tgl_indo($cuti->tgl_mulai_cuti_berakhir) }}</td>
										@else
										<td colspan="4"></td>
										@endif

										@php
										$tgl1 = strtotime($cuti->tgl_mulai_cuti);
										$tgl2 = strtotime($cuti->tgl_mulai_cuti_berakhir);
										$selisih =$tgl2 - $tgl1;
										$hari = $selisih / 60 / 60 / 24;
										@endphp

										@if($cuti->tgl_mulai_cuti != NULL && $cuti->tgl_mulai_cuti > '2016-04-01')
										<td colspan="5">{{ $hari + 1 }}</td>
										@else
										<td colspan="5">-</td>
										@endif
									</tr>
									<tr class="text-center">
										<td>Cuti Tahunan 年假</td>
										@if($cuti->tgl_mulai_cuti_tahunan != NULL && $cuti->tgl_mulai_cuti_tahunan > '2016-04-01')
										<td colspan="4">{{ tgl_indo($cuti->tgl_mulai_cuti_tahunan) }} - {{ tgl_indo($cuti->tgl_mulai_cuti_tahunan_berakhir) }}</td>
										@else
										<td colspan="4">-</td>
										@endif

										@php
										$tgl1 = strtotime($cuti->tgl_mulai_cuti_tahunan);
										$tgl2 = strtotime($cuti->tgl_mulai_cuti_tahunan_berakhir);
										$selisih =$tgl2 - $tgl1;
										$hari = $selisih / 60 / 60 / 24;
										@endphp

										@if($cuti->tgl_mulai_cuti_tahunan != NULL && $cuti->tgl_mulai_cuti_tahunan > '2016-04-01')
										<td colspan="5">{{ $hari + 1 }}</td>
										@else
										<td colspan="5">-</td>
										@endif
									</tr>
									<tr class="text-center">
										<td>OFF 休息日</td>
										@if($cuti->tgl_mulai_off != NULL && $cuti->tgl_mulai_off > '2016-04-01')
										<td colspan="4">{{ tgl_indo($cuti->tgl_mulai_off) }} - {{ tgl_indo($cuti->tgl_mulai_off_berakhir) }}</td>
										@else
										<td colspan="4">-</td>
										@endif

										@php
										$tgl1 = strtotime($cuti->tgl_mulai_off);
										$tgl2 = strtotime($cuti->tgl_mulai_off_berakhir);
										$selisih =$tgl2 - $tgl1;
										$hari = $selisih / 60 / 60 / 24;
										@endphp

										@if($cuti->tgl_mulai_off != NULL && $cuti->tgl_mulai_off > '2016-04-01')
										<td colspan="5">{{ $hari + 1 }}</td>
										@else
										<td colspan="5">-</td>
										@endif
									</tr>
									<tr>
										<th class="text-center" colspan="10">Detail Pemesanan Tiket Pesawat Detail Pemesanan Tiket Pesawat 飞机票预订详情</th>
									</tr>
									<tr>
										<td class="text-center" colspan="3">Keberangkatan 出港</td>
										<td class="text-center" colspan="7">Kepulangan 到达</td>
									</tr>
									<tr>
										<td>Tanggal</td>
										<td class="text-center" colspan="2">{{ tgl_indo($cuti->tgl_keberangkatan) }}</td>
										<td>Tanggal</td>
										<td class="text-center" colspan="6">{{ tgl_indo($cuti->tgl_kepulangan) }}</td>
									</tr>
									<tr>
										<td>Waktu</td>
										<td class="text-center" colspan="2">{{ $cuti->jam_keberangkatan }}</td>
										<td>Waktu</td>
										<td class="text-center" colspan="6">{{ $cuti->jam_kepulangan }}</td>
									</tr>
									<tr>
										<td>Dari</td>
										<td class="text-center" colspan="2">{{ $cuti->kota_awal_keberangkatan }}</td>
										<td>Dari</td>
										<td class="text-center" colspan="6">{{ $cuti->kota_awal_kepulangan }}</td>
									</tr>
									<tr>
										<td>Tujuan</td>
										<td class="text-center" colspan="2">{{ $cuti->kota_awal_kepulangan }}</td>
										<td>Tujuan</td>
										<td class="text-center" colspan="6">{{ $cuti->kota_tujuan_kepulangan }}</td>
									</tr>
									<tr>
										<td class="text-center" colspan="3">Catatan penting</td>
										<td class="text-center" colspan="7">Catatan penting</td>
									</tr>
									<tr>
										@if($cuti->catatan_penting_keberangkatan)
										<td class="text-center" colspan="3">{{ $cuti->catatan_penting_keberangkatan }}</td>
										@endif
										@if($cuti->catatan_penting_kepulangan)
										<td class="text-center" colspan="7">{{ $cuti->catatan_penting_kepulangan }}</td>
										@endif
										@if(!$cuti->catatan_penting_keberangkatan && !$cuti->catatan_penting_kepulangan)
										<td class="text-center" colspan="3"><br></td>
										<td class="text-center" colspan="7"><br></td>
										@endif
									</tr>
									<tr>
										<th colspan="10">II.b @if($cuti->tipe_rencana == '2') &radic; @endif WAKTU KERJA 工作时间</th>
									</tr>
									<tr>
										<td class="text-center" colspan="4">Tanggal Bekerja pada Periode Cuti Roster 在轮休假期工作日期</td>
										<td class="text-center" colspan="6">Total Hari Bekerja 在轮休假期来工作总数（天）</td>
									</tr>
									<tr>
										@if($cuti->tipe_rencana == '2')
										@php
										$tgl_cuti = new DateTime($cuti->tgl_awal_kerja);
										$tgl_sekarang = new DateTime($cuti->tgl_akhir_kerja);
										$tgl_jt_tempo = $tgl_sekarang->diff($tgl_cuti)->days;
										@endphp
										<td class="text-center" colspan="4">{{ tgl_indo($cuti->tgl_awal_kerja) }} - {{ tgl_indo($cuti->tgl_akhir_kerja) }}</td>
										<td class="text-center" colspan="6">{{ $tgl_jt_tempo + 1}}</td>
										@else
										<td class="text-center" colspan="4">-</td>
										<td class="text-center" colspan="6">-</td>
										@endif
									</tr>
									<tr>
										<td class="text-center" colspan="2" rowspan="2">Pemohon 申请人</td>
										<td class="text-center" colspan="2">Disetujui 批准</td>
										<td class="text-center" colspan="6">Diketahui 知悉</td>
									</tr>
									<tr>
										<td class="text-center" colspan="2">HOD 部门负责人</td>
										<td class="text-center" colspan="6">HRD 人事部门</td>
									</tr>
									<tr>
										<td colspan="2">
											<div class="text-center">
												<img src="{{ asset('assets/img/backgrounds/logo-disetujui.png') }}" style="height: 80px; width:120px" class="text-center">
											</div>
										</td>
										<td colspan="2">
											@if($cuti->status_pengajuan == 'diterima')
											<div class="text-center">
												<img src="{{ asset('assets/img/backgrounds/logo-disetujui.png') }}" style="height: 80px; width:120px" class="text-center">
											</div>
											@endif
										</td>
										<td colspan="6">
											@if($cuti->status_pengajuan_hrd == 'diterima')
											<div class="text-center">
												<img src="{{ asset('assets/img/backgrounds/logo-disetujui.png') }}" style="height: 80px; width:120px" class="text-center">
											</div>
											@endif
										</td>
									</tr>
								</tbody>
							</table>
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
		@endpush

</x-app-layout>
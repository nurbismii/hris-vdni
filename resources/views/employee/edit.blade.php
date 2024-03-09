<x-app-layout title="Edit Data Karyawan">
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
	@endpush

	<header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
		<div class="container-xl px-4">
			<div class="page-header-content">
				<div class="row align-items-center justify-content-between pt-3">
					<div class="col-auto mb-3">
						<h1 class="page-header-title">
							<div class="page-header-icon"><i data-feather="user"></i></div>
							Detail Data Karyawan
						</h1>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Main page content-->
	<div class="container-xl px-4 mt-4">
		<div class="row">
			<div class="col-xl-4">
				<!-- Profile picture card-->
				<div class="card mb-3 mb-xl-0">
					<div class="card-header">Foto Karyawan</div>
					<div class="card-body text-center">
						<img class="img-account-profile rounded-circle mb-2" src="{{ asset('assets/img/illustrations/profiles/profile-1.png') }}" alt="" />
					</div>
				</div>
				<form action="{{ route('update.kontrak', $data->nik) }}" class="mb-3" method="post">
					@csrf
					{{ method_field('patch')}}
					<div class="card mb-3 mt-3 mb-xl-0">
						<div class="card-header">kontrak</div>
						<div class="card-body">
							<div class="row gx-3">
								<div class="col-md-12 mb-2">
									<label class="small mb-1">NO SK PKWTT</label>
									<input class="form-control" type="text" name="no_sk_pkwtt" value="{{ $data->no_sk_pkwtt }}" />
								</div>
							</div>
							<div class="row gx-3">
								<div class="col-md-12 mb-2">
									<label class="small mb-1">Perbarui status kontrak</label>
									<select name="status_karyawan" class="form-select" id="">
										<option value="{{ $data->status_karyawan }}" selected>{{ $data->status_karyawan }}</option>
										@if($data->status_karyawan != 'PKWTT 固定工')
										<option value="PKWTT 固定工">PKWTT 固定工</option>
										@endif
										@if($data->status_karyawan != 'PKWT 合同工')
										<option value="PKWT 合同工">PKWT 合同工</option>
										@endif
									</select>
								</div>
							</div>
							<div class="row gx-3 mb-2">
								<div class="col-md-12 mb-2">
									<label class="small mb-1">Perbarui status karyawan</label>
									<select name="status_resign" class="form-select" id="">
										<option value="{{ $data->status_resign }}" selected>{{ $data->status_resign }}</option>
										@if($data->status_resign != 'Aktif')
										<option value="Aktif">Aktif</option>
										@endif
										@if($data->status_resign != 'Mutasi')
										<option value="Mutasi">Mutasi</option>
										@endif
										@if($data->status_resign != 'PHK')
										<option value="PHK">PHK</option>
										@endif
										@if($data->status_resign != 'Pengembalian')
										<option value="Pengembalian">Pengembalian</option>
										@endif
										@if($data->status_resign != 'Efisiensi')
										<option value="Efisiensi">Efisiensi</option>
										@endif
									</select>
								</div>
							</div>
							<div class="row gx-3 mb-2">
								<div class="col-md-12 mb-2">
									<label class="small mb-1">Status Keluar</label>
									<input class="form-control" type="text" name="kategori_keluar" value="{{ $data->kategori_keluar }}" readonly />
								</div>
							</div>
							<button class="btn btn-primary" type="submit">Perbarui</button>
						</div>
					</div>
				</form>
				<div class="card mb-3 mb-xl-0">
					<div class="card card-header-actions h-100">
						<div class="card-header text-primary 75">
							Riwayat cuti dan izin
						</div>
						<div class="card-body">
							<div class="timeline timeline-xs">
								@forelse($data->cutiIzin as $row)
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Mulai {{date('d F Y', strtotime($row->tanggal_mulai))}} berakhir {{ date('d F Y', strtotime($row->tanggal_berakhir))}}">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text">{{ date('d/m/Y', strtotime($row->tanggal)) }}</div>
										@if(strtoupper($row->tipe) == 'CUTI')
										<div class="timeline-item-marker-indicator bg-green"></div>
										@elseif(strtoupper($row->tipe) == 'IZIN DIBAYARKAN')
										<div class="timeline-item-marker-indicator bg-info"></div>
										@elseif(strtoupper($row->tipe) == 'IZIN TIDAK DIBAYARKAN')
										<div class="timeline-item-marker-indicator bg-primary"></div>
										@else
										<div class="timeline-item-marker-indicator bg-primary"></div>
										@endif
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark text-xs" href="#!">[{{strtoupper($row->tipe)}}] </a> <br>
										<a class="fw-bold text-dark text-xs" href="#!">({{$row->jumlah}} Hari)</a> <br>
										<a class="fw-bold text-dark text-xs" href="#!">{{ $row->keterangan }} </a>
									</div>
								</div>
								@empty
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text"></div>
										<div class="timeline-item-marker-indicator bg-dark"></div>
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark" href="#!">Tidak ada catatan</a>
									</div>
								</div>
								@endforelse
							</div>
						</div>
					</div>
				</div>
				<div class="card mb-3 mt-3 mb-xl-0">
					<div class="card card-header-actions h-100">
						<div class="card-header text-primary 75">
							Riwayat mutasi
						</div>
						<div class="card-body">
							<div class="timeline timeline-xs">
								@forelse($mutasi as $row)
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text">{{ date('d/m/Y', strtotime($row->tanggal_mutasi)) }}</div>
										<div class="timeline-item-marker-indicator bg-primary"></div>
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark" href="#!">{{ getNamaDepartemen($row->posisi_lama->departemen_lama_id) ?? '' }} </a> <br>
										<a class="fw-bold text-xs" href="#!">{{ getNamaDivisi($row->posisi_lama->divisi_lama_id) ?? '' }} </a><br>
										<a class="fw-bold text-xs" href="#!">{{ $row->jabatan ?? '' }} </a>
									</div>
								</div>
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text">{{ date('d/m/Y') }}</div>
										<div class="timeline-item-marker-indicator bg-success"></div>
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark" href="#!">{{ $row->employee->divisi->departemen->departemen ?? '' }} </a><br>
										<a class="fw-bold text-xs" href="#!">{{ $row->employee->divisi->nama_divisi ?? '' }} </a> <br>
										<a class="fw-bold text-xs" href="#!">{{ $row->jabatan ?? '' }} </a>
									</div>
								</div>
								<hr class="mt-0 mb-2">
								@empty
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text"></div>
										<div class="timeline-item-marker-indicator bg-dark"></div>
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark" href="#!">Tidak ada catatan</a>
									</div>
								</div>
								@endforelse
							</div>
						</div>
					</div>
				</div>
				<div class="card mb-3 mt-3 mb-xl-0">
					<div class="card card-header-actions h-100">
						<div class="card-header text-primary 75">
							Riwayat peringatan
						</div>
						<div class="card-body">
							<div class="timeline timeline-xs">
								@forelse($data->spreportMany as $row)
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="Mulai {{date('d F Y', strtotime($row->tgl_mulai))}} berakhir {{ date('d F Y', strtotime($row->tgl_berakhir))}}">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text">{{ $row->no_sp }}</div>
										<div class="timeline-item-marker-indicator bg-red"></div>
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark" href="#!">({{$row->pelapor}}) {{ $row->keterangan }} </a>
									</div>
								</div>
								@empty
								<div class="timeline-item" data-bs-toggle="tooltip" data-bs-placement="right" title="">
									<div class="timeline-item-marker">
										<div class="timeline-item-marker-text"></div>
										<div class="timeline-item-marker-indicator bg-dark"></div>
									</div>
									<div class="timeline-item-content">
										<a class="fw-bold text-dark" href="#!">Tidak ada catatan</a>
									</div>
								</div>
								@endforelse
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-xl-8">
				<!-- Account details card-->
				<div class="card mb-4">
					<div class="card-header">Detail Data Karyawan</div>
					<div class="card-body">
						<form action="{{ route('update.employee', $data->nik) }}" method="POST">
							@csrf
							{{ method_field('patch') }}

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">NIK KK</label>
									<input class="form-control" type="text" name="no_kk" value="{{ $data->no_kk }}" />
								</div>
								<div class="col-md-3 mb-3">
									<label class="small mb-1">Cuti tahunan</label>
									<input class="form-control" type="text" name="sisa_cuti" value="{{ $data->sisa_cuti }}" />
								</div>
								<div class="col-md-3 mb-3">
									<label class="small mb-1">Cuti Covid</label>
									<input class="form-control" type="text" name="sisa_cuti_covid" value="{{ $data->sisa_cuti_covid }}" />
								</div>
							</div>

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Nama Karyawan</label>
									<input class="form-control" type="text" name="nama_karyawan" value="{{ $data->nama_karyawan }}" />
								</div>
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Nama Ibu Kandung</label>
									<input class="form-control" type="text" name="nama_ibu_kandung" value="{{ $data->nama_ibu_kandung }}" />
								</div>
							</div>

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">NIK Karyawan</label>
									<input class="form-control" type="text" name="nik_karyawan" value="{{ $data->nik }}" readonly />
								</div>
								<div class="col-md-6 mb-3">
									<label class="small mb-1">NO KTP</label>
									<input class="form-control" type="text" name="no_ktp" value="{{ $data->no_ktp }}" />
								</div>
							</div>

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Departemen</label>
									<input class="form-control" type="text" name="" value="{{ isset($data->divisi->departemen->departemen) != '' ? $data->divisi->departemen->departemen : ''}}" disabled />
								</div>
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Divisi</label>
									<input class="form-control" type="text" name="" value="{{ isset($data->divisi->nama_divisi) != '' ? $data->divisi->nama_divisi : ''}}" disabled />
								</div>
							</div>

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Posisi</label>
									<input class="form-control" type="text" name="posisi" value="{{ $data->posisi }}" disabled />
								</div>
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Jabatan</label>
									<input class="form-control" type="text" name="jabatan" value="{{ $data->jabatan ?? '-' }}" disabled />
								</div>
							</div>

							<div class="col-md-12 mb-3">
								<label class="small mb-1">ALAMAT</label>
								<textarea name="alamat_ktp" class="form-control" cols="30" rows="10">{{ $data->alamat_ktp }}</textarea>
							</div>

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Jenis Kelamin</label>
									<select class="form-select" name="jenis_kelamin">
										<option value="{{ $data->jenis_kelamin }}" selected>{{ $data->jenis_kelamin == 'L' ? 'Laki - Laki' : 'Perempuan' }}</option>
										@if($data->jenis_kelamin == 'L')
										<option value="P">Perempuan</option>
										@else
										<option value="L">Laki - Laki</option>
										@endif
									</select>
								</div>

								<div class="col-md-6 mb-3">
									<label class="small mb-1">Status Perkawinan</label>
									<select class="form-select" name="status_perkawinan">
										<option value="{{ $data->status_perkawinan }}" selected>{{ $data->status_perkawinan }}</option>
										@if($data->status_perkawinan != 'Kawin')
										<option value="Kawin">Kawin</option>
										@else
										<option value="Belum Kawin">Belum Kawin</option>
										@endif
									</select>
								</div>
							</div>

							<div class="row gx-3">
								<div class="col-md-6 mb-3">
									<label class="small mb-1">Email</label>
									<input class="form-control" type="email" value="{{ $data->user->email ?? 'Belum terdaftar sebagai pengguna' }}" readonly />
								</div>

								<div class="col-md-6 mb-3">
									<label class="small mb-1">Agama</label>
									<input class="form-control" type="text" value="{{ $data->agama ?? '-' }}" readonly />
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Tanggal Lahir</label>
										<input class="form-control" type="date" name="tgl_lahir" value="{{ date('Y-m-d', strtotime($data->tgl_lahir)) }}" />
									</div>
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Entry Date</label>
										<input class="form-control" type="date" name="entry_date" value="{{ date('Y-m-d', strtotime($data->entry_date)) }}" />
									</div>
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">No Telp</label>
										<input class="form-control" name="no_telp" type="no_telp" value="{{ $data->no_telp }}" />
									</div>

									<div class="col-md-6 mb-3">
										<label class="small mb-1">NPWP</label>
										<input class="form-control" type="text" name="npwp" value="{{ $data->npwp }}" />
									</div>
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">BPSJ Kesehatan</label>
										<input class="form-control" name="bpjs_kesehatan" type="text" value="{{ $data->bpjs_kesehatan }}" />
									</div>
									<div class="col-md-6 mb-3">
										<label class="small mb-1">BPJS Ketenagakerjaan</label>
										<input class="form-control" name="bpjs_tk" type="text" name="bpjs_tk" value="{{ $data->bpjs_tk }}" />
									</div>
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Provinsi</label>
										<input class="form-control" type="text" name="" value="{{ $data->provinsi->provinsi ?? '' }}" readonly />
									</div>
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Kabupaten</label>
										<input class="form-control" type="text" name="" value="{{ $data->kabupaten->kabupaten ?? '' }}" readonly />
									</div>
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Kecamatan</label>
										<input class="form-control" type="text" name="" value="{{ $data->kecamatan->kecamatan ?? '' }}" readonly />
									</div>
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Kelurahan</label>
										<input class="form-control" type="text" name="" value="{{ $data->kelurahan->kelurahan ?? '' }}" readonly />
									</div>
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Vaksin</label>
										<select name="vaksin" class="form-select">
											<option value="{{ $data->vaksin }}">{{ $level_vaksin }}</option>
											<option value="1">Vaksin 1</option>
											<option value="2">Vaksin 2</option>
											<option value="3">Booster 1</option>
											<option value="4">Booster 2</option>
										</select>
									</div>

									<div class="col-md-6 mb-3">
										<label class="small mb-1">Jam Kerja</label>
										<input class="form-control" type="text" name="jam_kerja" value="{{ $data->jam_kerja }}" />
									</div>
								</div>

								<div class="row gx-3">
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Area Kerja</label>
										<input class="form-control" type="text" name="area_kerja" value="{{ $data->area_kerja }}" />
									</div>
									<div class="col-md-6 mb-3">
										<label class="small mb-1">Golongan Darah</label>
										<input class="form-control" type="text" name="golongan_darah" value="{{ $data->golongan_darah }}" />
									</div>
								</div>
								<div class="d-flex justify-content-between">
									<a href="/employees" class="btn btn-light" type="button">Kembali</a>
									<button class="btn btn-primary" type="submit">Perbarui</button>
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
	@endpush

</x-app-layout>
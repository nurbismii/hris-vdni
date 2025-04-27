<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title>Laporan Wilayah</title>
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<style>
		body {
			font-family: 'DejaVu Sans', sans-serif;
			font-size: 12px;
			background-color: #fff;
			padding: 30px;
			color: #333;
		}

		.title {
			text-align: center;
			font-size: 18px;
			font-weight: bold;
			margin-bottom: 30px;
			border-bottom: 2px solid #333;
			padding-bottom: 10px;
			text-transform: uppercase;
			letter-spacing: 1px;
		}

		.table-bordered th,
		.table-bordered td {
			border: 1px solid #ccc !important;
			vertical-align: middle;
		}

		.table-primary {
			background-color: #dbe9f7 !important;
			font-weight: bold;
		}

		.table-success {
			background-color: #e6f4ea !important;
			font-weight: bold;
		}

		.summary-table {
			margin-bottom: 30px;
		}

		.summary-table th {
			width: 25%;
			background-color: #f8f9fa;
		}

		.section-title {
			margin-top: 40px;
			margin-bottom: 10px;
			font-size: 14px;
			font-weight: bold;
			border-left: 5px solid #0d6efd;
			padding-left: 10px;
		}

		.footer {
			margin-top: 50px;
			text-align: center;
			font-size: 10px;
			color: #777;
		}
	</style>
</head>

<body>
	<div class="title">Hasil Laporan Wilayah</div>

	<table class="table table-bordered summary-table">
		<tr>
			<th>Area Kerja</th>
			<td>: @foreach($area_arr as $a) {{ $a }} @endforeach</td>
		</tr>
		<tr>
			<th>Provinsi</th>
			<td>: @foreach($prov_arr as $p) {{ getNamaProvinsi($p) }} @endforeach</td>
		</tr>
		<tr>
			<th>Kabupaten</th>
			<td>:
				@for($i=0; $i < count($kab_arr); $i++)
					{{ getNamaKabupaten($kab_arr[$i]) }}
					@if($i==count($kab_arr) - 2) dan
					@elseif($i < count($kab_arr) - 2),
					@endif
					@endfor.
					</td>
		</tr>
		<tr>
			<th>Kecamatan</th>
			<td>:
				@for($i=0; $i < count($kec_arr); $i++)
					{{ getNamaKecamatan($kec_arr[$i]) }}
					@if($i==count($kec_arr) - 2) dan
					@elseif($i < count($kec_arr) - 2),
					@endif
					@endfor.
					</td>
		</tr>
		@php $total_objek = 0; @endphp
		@foreach($array as $kabupaten)
		@foreach($kabupaten as $kecamatan)
		@php $total_objek += count($kecamatan); @endphp
		@endforeach
		@endforeach
		<tr>
			<th>Jumlah Kelurahan/Desa</th>
			<td>: {{ $total_objek }}</td>
		</tr>
	</table>

	{{-- Main Data Loop --}}
	@foreach ($response as $kabupatenId => $kecamatans)
	@foreach ($kecamatans as $kecamatanId => $dataList)
	<div class="section-title">{{ getNamaKabupaten($kabupatenId) }} - Kecamatan {{ getNamaKecamatan($kecamatanId) }}</div>

	@php
	$groupedByKelurahan = [];
	$totalKaryawanKecamatan = 0;
	@endphp

	@foreach ($dataList as $genderGroup)
	@foreach ($genderGroup as $data)
	@php
	$kelurahanId = $data->kelurahan_id;
	$jk = strtolower($data->jenis_kelamin);
	if ($jk === 'l' || $jk === 'laki-laki') {
	$gender = 'laki-laki';
	} elseif ($jk === 'p' || $jk === 'perempuan') {
	$gender = 'perempuan';
	} else {
	$gender = 'lainnya'; // opsional, bisa dilewati
	}
	if (in_array($gender, ['laki-laki', 'perempuan'])) {
        if (!isset($groupedByKelurahan[$kelurahanId])) {
            $groupedByKelurahan[$kelurahanId] = [
                'perempuan' => 0,
                'laki-laki' => 0,
                'jumlah' => 0,
            ];
        }

        $groupedByKelurahan[$kelurahanId][$gender] += $data->jumlah_karyawan;
        $groupedByKelurahan[$kelurahanId]['jumlah'] += $data->jumlah_karyawan;
        $totalKaryawanKecamatan += $data->jumlah_karyawan;
    }
	@endphp
	@endforeach
	@endforeach

	<table class="table table-bordered mb-4">
		<thead>
			<tr class="table-primary text-center">
				<th>Kelurahan/Desa</th>
				<th>Perempuan</th>
				<th>Laki-laki</th>
				<th>Jumlah Karyawan</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($groupedByKelurahan as $kelurahanId => $info)
			<tr>
				<td>{{ getNamaKelurahanMultiple($kelurahanId) }}</td>
				<td class="text-end">{{ $info['perempuan'] }}</td>
				<td class="text-end">{{ $info['laki-laki'] }}</td>
				<td class="text-end">{{ $info['jumlah'] }}</td>
			</tr>
			@endforeach
			<tr class="table-secondary">
				<td class="text-end"><strong>Total Karyawan Kecamatan</strong></td>
				<td class="text-end"><strong>{{ array_sum(array_column($groupedByKelurahan, 'perempuan')) }}</strong></td>
				<td class="text-end"><strong>{{ array_sum(array_column($groupedByKelurahan, 'laki-laki')) }}</strong></td>
				<td class="text-end"><strong>{{ $totalKaryawanKecamatan }}</strong></td>
			</tr>
		</tbody>
	</table>
	@endforeach
	@endforeach

	<div class="footer">
		Dicetak secara otomatis oleh sistem &mdash; {{ date('d/m/Y H:i') }}
	</div>
</body>

</html>
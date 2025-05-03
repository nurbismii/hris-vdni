@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Laporan Wilayah Karyawan</h2>

    <!-- Filter -->
    <form method="GET" action="{{ route('wilayah.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="area_kerja">Area Kerja</label>
            <select class="form-select select2" name="area_kerja" id="area_kerja">
                <option value="">Semua</option>
                @foreach ($area_kerja as $area)
                    <option value="{{ $area }}" {{ request('area_kerja') == $area ? 'selected' : '' }}>{{ $area }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="provinsi_id">Provinsi</label>
            <select class="form-select select2" name="provinsi_id" id="provinsi_id">
                <option value="">Semua</option>
                @foreach ($provinsi as $prov)
                    <option value="{{ $prov->id }}" {{ request('provinsi_id') == $prov->id ? 'selected' : '' }}>{{ $prov->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 align-self-end">
            <button type="submit" class="btn btn-primary">Terapkan</button>
        </div>
        <div class="col-md-3 align-self-end text-end">
            <a href="{{ route('wilayah.export', request()->query()) }}" class="btn btn-success">Export Excel</a>
        </div>
    </form>

    <!-- Tabel -->
    <div class="table-responsive">
        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Provinsi</th>
                    <th rowspan="2">Kabupaten</th>
                    <th rowspan="2">Kecamatan</th>
                    <th rowspan="2">Kelurahan</th>
                    <th colspan="3" class="text-center">Jumlah Karyawan</th>
                </tr>
                <tr>
                    <th>L</th>
                    <th>P</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($array as $prov)
                    @foreach ($prov['children'] as $kab)
                        @foreach ($kab['children'] as $kec)
                            @foreach ($kec['children'] as $kel)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $prov['nama'] }}</td>
                                    <td>{{ $kab['nama'] }}</td>
                                    <td>{{ $kec['nama'] }}</td>
                                    <td>{{ $kel['nama'] }}</td>
                                    <td>{{ $kel['l'] }}</td>
                                    <td>{{ $kel['p'] }}</td>
                                    <td>{{ $kel['total'] }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Chart -->
    <canvas id="chartKelurahan" height="100" class="mt-5"></canvas>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartKelurahan').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($arr_nama_kelurahan),
            datasets: [{
                label: 'Jumlah Karyawan',
                data: @json($arr_jumlah_karyawan),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 10 }
                }
            }
        }
    });

    $(document).ready(function() {
        $('.select2').select2({ theme: 'bootstrap-5' });
    });
</script>
@endpush

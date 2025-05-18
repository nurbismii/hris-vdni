<x-app-layout title="Wilayah">
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
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Laporan Wilayah
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content-->
    <div class="container-fluid px-4">
        <nav class="nav nav-borders">
            <a class="nav-link ms-0 {{ (request()->segment(1) == 'employees') ? 'active' : '' }} " href="/employees">Provinsi</a>
            <a class="nav-link ms-0" href="/employees/monthly">Kabupaten</a>
            <a class="nav-link ms-0" href="/employees/weekly">Kecamatan</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <!-- Filter -->
        <form method="GET" action="{{ route('wilayah.index') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="area_kerja">Area Kerja</label>
                <select class="form-select select2" name="area_kerja[]" id="area_kerja">
                    <option value="">Semua</option>
                    @foreach ($area_kerja as $area)
                    <option value="{{ $area }}" {{ request('area_kerja') == $area ? 'selected' : '' }}>{{ $area }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Terapkan</button>
            </div>
            <div class="col-md-4 align-self-end text-end">
                <a href="{{ route('export-wilayah-excel') }}" class="btn btn-success">Export Excel</a>
            </div>
        </form>

        <!-- Tabel -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-table me-2"></i>Distribusi Karyawan per Wilayah</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th rowspan="2">Provinsi</th>
                                    <th colspan="3" class="text-center">Jumlah Karyawan</th>
                                </tr>
                                <tr>
                                    <th>Laki Laki</th>
                                    <th>Perempuan</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($response as $region => $provinsis)
                                @php
                                $region_id = Str::slug($region); // Untuk id HTML unique
                                $total_l = $total_p = $total_all = 0;
                                foreach ($provinsis as $prov) {
                                foreach ($prov['kabupaten'] as $kab) {
                                foreach ($kab['kecamatan'] as $kec) {
                                foreach ($kec['kelurahan'] as $kel) {
                                $total_l += $kel['laki-laki'];
                                $total_p += $kel['perempuan'];
                                $total_all += $kel['jumlah'];
                                }
                                }
                                }
                                }
                                @endphp
                                <tr>
                                    <td>{{ strtoupper($region) }}</td>
                                    <td>{{ $total_l }}</td>
                                    <td>{{ $total_p }}</td>
                                    <td>
                                        {{ $total_all }}
                                        <button class="btn btn-sm btn-outline-primary ms-2 float-end" data-bs-toggle="collapse" data-bs-target="#region-{{ $region_id }}">
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                                <tr class="collapse" id="region-{{ $region_id }}">
                                    <td colspan="8" class="p-0">
                                        <div class="p-3">
                                            <input type="text" class="form-control mb-2 search-detail" placeholder="Cari Kabupaten, Kecamatan, atau Kelurahan..." data-target="#region-{{ $region_id }}">
                                        </div>
                                        <table class="table table-bordered mb-0">
                                            @foreach ($provinsis as $prov)
                                            <thead class="table-light">
                                                <tr>
                                                    <th colspan="8" class="ps-4">{{ $prov['nama'] ?? 'Tanpa Nama Provinsi' }}</th>
                                                </tr>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Provinsi</th>
                                                    <th>Kabupaten</th>
                                                    <th>Kecamatan</th>
                                                    <th>Kelurahan</th>
                                                    <th>L</th>
                                                    <th>P</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @php
                                                $hasDetail = false;
                                                $prov_total_l = $prov_total_p = $prov_total_all = 0;
                                                @endphp

                                                @foreach ($prov['kabupaten'] as $kab)
                                                @php
                                                $kab_total_l = $kab_total_p = $kab_total_all = 0;
                                                @endphp

                                                @foreach ($kab['kecamatan'] as $kec)
                                                @php
                                                $kec_total_l = $kec_total_p = $kec_total_all = 0;
                                                @endphp

                                                @foreach ($kec['kelurahan'] as $kel)
                                                @php
                                                $hasDetail = true;
                                                $l = $kel['laki-laki'] ?? 0;
                                                $p = $kel['perempuan'] ?? 0;
                                                $j = $kel['jumlah'] ?? 0;

                                                $prov_total_l += $l;
                                                $prov_total_p += $p;
                                                $prov_total_all += $j;

                                                $kab_total_l += $l;
                                                $kab_total_p += $p;
                                                $kab_total_all += $j;

                                                $kec_total_l += $l;
                                                $kec_total_p += $p;
                                                $kec_total_all += $j;
                                                @endphp
                                                <tr class="searchable-row">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $prov['nama'] }}</td>
                                                    <td>{{ $kab['nama'] }}</td>
                                                    <td>{{ $kec['nama'] }}</td>
                                                    <td>{{ $kel['nama'] }}</td>
                                                    <td>{{ $l }}</td>
                                                    <td>{{ $p }}</td>
                                                    <td>{{ $j }}</td>
                                                </tr>
                                                @endforeach

                                                {{-- Total Kecamatan --}}
                                                <tr class="row-total-kec table-light">
                                                    <td colspan="5" class="text-end">TOTAL KEC. {{ $kec['nama'] }}</td>
                                                    <td>{{ $kec_total_l }}</td>
                                                    <td>{{ $kec_total_p }}</td>
                                                    <td>{{ $kec_total_all }}</td>
                                                </tr>
                                                @endforeach

                                                {{-- Total Kabupaten --}}
                                                <tr class="row-total-kab table-primary fw-semibold">
                                                    <td colspan="5" class="text-end">TOTAL KAB. {{ $kab['nama'] }}</td>
                                                    <td>{{ $kab_total_l }}</td>
                                                    <td>{{ $kab_total_p }}</td>
                                                    <td>{{ $kab_total_all }}</td>
                                                </tr>
                                                @endforeach

                                                @if (!$hasDetail)
                                                <tr>
                                                    <td colspan="8" class="text-center text-muted">Data tidak tersedia</td>
                                                </tr>
                                                @endif

                                                {{-- Total Provinsi --}}
                                                <tr class="table-secondary fw-bold">
                                                    <td colspan="5" class="text-end">TOTAL {{ $prov['nama'] }}</td>
                                                    <td>{{ $prov_total_l }}</td>
                                                    <td>{{ $prov_total_p }}</td>
                                                    <td>{{ $prov_total_all }}</td>
                                                </tr>
                                            </tbody>
                                            @endforeach
                                        </table>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Chart -->
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <span><i class="fas fa-chart-pie me-2"></i>Distribusi Karyawan per Wilayah</span>
            </div>
            <div class="card-body">
                <div class="mx-auto" style="max-width: 400px;">
                    <canvas id="chartKelurahan" height="400" width="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <x-toastr />

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

    <script>
        const regionData = @json($arr_region_data);

        const regionLabels = regionData.map(item => item.region_nama);
        const regionValues = regionData.map(item => item.region_jumlah);
        const total = regionValues.reduce((a, b) => a + b, 0);

        const ctx = document.getElementById('chartKelurahan').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: regionLabels,
                datasets: [{
                    label: 'Jumlah Karyawan per Wilayah',
                    data: regionValues,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let percentage = (value / total * 100).toFixed(1) + '%';
                            let label = ctx.chart.data.labels[ctx.dataIndex];
                            return label + '\n' + percentage;
                        },
                        color: '#000',
                        font: {
                            weight: 'bold'
                        }
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

        $(document).ready(function() {
            $('.select2').select2({
                theme: 'bootstrap-5'
            });
        });

        $(document).on('input', '.search-detail', function() {
            const keyword = $(this).val().toLowerCase();
            const parentSelector = $(this).data('target');
            const $region = $(parentSelector);
            const $rows = $region.find('.searchable-row');
            const $totalRows = $region.find('.row-total-kec, .row-total-kab');

            // Filter rows
            $rows.each(function() {
                const rowText = $(this).text().toLowerCase();
                $(this).toggle(rowText.includes(keyword));
            });

            // Periksa apakah total kecamatan punya baris yang masih tampil
            $region.find('.row-total-kec').each(function() {
                const $this = $(this);
                const prevRows = $this.prevUntil('.row-total-kec, .row-total-kab').filter(':visible');
                $this.toggle(prevRows.length > 0);
            });

            // Periksa apakah total kabupaten punya baris yang masih tampil
            $region.find('.row-total-kab').each(function() {
                const $this = $(this);
                const prevRows = $this.prevUntil('.row-total-kab').filter('.row-total-kec:visible');
                $this.toggle(prevRows.length > 0);
            });
        });

        $(document).on('hide.bs.collapse', '.collapse', function() {
            $(this).find('.search-detail').val('');
            $(this).find('.searchable-row').show();
        });
    </script>
    @endpush
</x-app-layout>
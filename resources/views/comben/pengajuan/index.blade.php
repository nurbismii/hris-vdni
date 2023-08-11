<x-app-layout title="Karyawan">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/datetime/1.4.0/css/dataTables.dateTime.min.css" rel="stylesheet" />

    <!-- Toastr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @endpush
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Data Pengajuan Karyawan
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="data-table-pengajuan" class="table table-hover" style="width: 100%;">
                            <div class="mb-3 col-3">
                                <select name="status_hrd" class="form-select" id="status_hrd">
                                    <option value="" selected>- Pilih status pengajuan-</option>
                                    <option value="Menunggu">Menunggu</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                            <hr class="mt-0 mb-4" />
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <th>Mulai</th>
                                    <th>Selesai</th>
                                    <th>Cuti</th>
                                    <th>Status HOD</th>
                                    <th>Status HRD</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <x-toastr />

    <script type="text/javascript">
        function confirmApprove() {
            return confirm('Kamu yakin ingin menyetujui pengajuan ini ?');
        }

        function confirmReject() {
            return confirm('Kamu yakin ingin menolak pengajuan ini ?');
        }

        function confirmDestroy() {
            return confirm('Kamu yakin ingin menghapus pengajuan ini ?');
        }
    </script>

    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
    <script src="{{ asset('js/litepicker.js')}}"></script>
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.4.0/js/dataTables.dateTime.min.js"></script>
    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#data-table-pengajuan').DataTable({
                pageLength: 10,
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                ajax: {
                    url: "pengajuan-karyawan/server-side",
                    data: function(d) {
                        d.status_hrd = $('#status_hrd').val(),
                            d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'nik_karyawan',
                        name: 'nik_karyawan'
                    },
                    {
                        data: 'nama_karyawan',
                        name: 'nama_karyawan',
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    {
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai'
                    },
                    {
                        data: 'tanggal_berakhir',
                        name: 'tanggal_berakhir'
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah'
                    },
                    {
                        data: 'status_hod',
                        name: 'status_hod'
                    },
                    {
                        data: 'status_hrd',
                        name: 'status_hrd'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [2, 'DESC']
                ]
            });

            $('#status_hrd').change(function() {
                table.draw();
            });
        });
    </script>

    @endpush
</x-app-layout>
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
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <style>
        span.select2.select2-container.select2-container--classic {
            width: 100% !important;
        }
    </style>
    @endpush
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-s4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="users"></i></div>
                            Employee Salary
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#modalGenerate">
                            <i class="me-1" data-feather="upload-cloud"></i>
                            Genarate Slip
                        </a>
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('create.salary') }}">
                            <i class="me-1" data-feather="plus"></i>
                            Add Salary
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-collapsable mb-3">
                    <a class="card-header" href="#collapseFilterKaryawan" data-bs-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">Employee filter
                        <div class="card-collapsable-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </a>
                    <div class="collapse show" id="collapseFilterKaryawan">
                        <form action="{{ route('salary.employee') }}" method="get">
                            @csrf
                            <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    <div class="col-md-6 mb-2">
                                        <label class="small mb-1">Departemen</label>
                                        <select class="form-select" name="departemen" id="departemen_search">
                                            <option value="">- Pilih Departemen -</option>
                                            @foreach($departement as $d)
                                            <option value="{{ $d->id }}">{{ $d->departemen }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label class="small mb-1">Divisi</label>
                                        <select class="form-control" name="divisi" id="divisi_search"></select>
                                    </div>
                                </div>
                                <a class="btn btn-sm btn-light text-primary" href="/employees">
                                    <i class="me-1" data-feather="trash"></i>
                                    Bersihkan filter
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto;">
                        <table id="data-table-salary" class="table table-hover" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Employee ID</th>
                                    <th>Departement</th>
                                    <th>Divisi</th>
                                    <th>Working days</th>
                                    <th>Join Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody> </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal add salary -->
    <div class="modal fade" id="modalAddSalary" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add salary</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
            </div>
        </div>
    </div>
    <!-- Modal add salary end -->

    @push('scripts')
    <x-toastr />
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

    <script>
        $(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('#data-table-salary').DataTable({
                pageLength: 15,
                processing: true,
                serverSide: true,
                searching: true,
                responsive: true,
                ajax: {
                    url: "/salary/server-side",
                    data: function(d) {
                        d.departemen = $('#departemen_search').val()
                        d.nama_divisi = $('#divisi_search').val()
                        d.search = $('input[type="search"]').val()
                    }
                },
                columns: [{
                        data: 'nama_karyawan',
                        name: 'nama_karyawan'
                    },
                    {
                        data: 'nik',
                        name: 'nik',
                    },
                    {
                        data: 'departemen',
                        name: 'departemen',
                    },
                    {
                        data: 'nama_divisi',
                        name: 'nama_divisi',
                    },
                    {
                        data: 'jumlah_hari_kerja',
                        name: 'jumlah_hari_kerja',
                    },

                    {
                        data: 'entry_date',
                        name: 'entry_date',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    },
                ],
                order: [
                    [0, 'desc']
                ]
            });

            $('#departemen_search').change(function() {
                table.draw();
            });

            $('#divisi_search').change(function() {
                table.draw();
            });
        });

        $(document).ready(function() {
            $('#departemen_search').on('change', function() {
                var deptID = $(this).val();
                if (deptID) {
                    $.ajax({
                        url: '/employees/divisi/' + deptID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data) {
                                $('#divisi_search').empty();
                                $('#divisi_search').append('<option hidden>- Pilih Divisi -</option>');
                                $.each(data, function(id, divisi) {
                                    $('select[name="divisi"]').append('<option value="' + divisi.id + '">' + divisi.nama_divisi + '</option>');
                                });
                            } else {
                                $('#divisi_search').empty();
                            }
                        }
                    });
                } else {
                    $('#divisi_search').empty();
                }
            });
        });

        var rupiah_makan = document.getElementById("rupiah_makan");
        rupiah_makan.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah_makan.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah_makan = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah_makan += separator + ribuan.join(".");
            }

            rupiah_makan = split[1] != undefined ? rupiah_makan + "," + split[1] : rupiah_makan;
            return prefix == undefined ? rupiah_makan : rupiah_makan ? "Rp" + rupiah_makan : "";
        }

        var rupiah_gaji = document.getElementById("rupiah_gaji");
        rupiah_gaji.addEventListener("keyup", function(e) {
            // tambahkan 'Rp.' pada saat form di ketik
            // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
            rupiah_gaji.value = formatRupiah(this.value, "Rp. ");
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah_gaji = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah_gaji += separator + ribuan.join(".");
            }

            rupiah_gaji = split[1] != undefined ? rupiah_gaji + "," + split[1] : rupiah_gaji;
            return prefix == undefined ? rupiah_gaji : rupiah_gaji ? "Rp" + rupiah_gaji : "";
        }
    </script>
    @endpush
</x-app-layout>
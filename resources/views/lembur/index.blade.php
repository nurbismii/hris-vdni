<x-app-layout title="Kelola Lembur">
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
  <style>
    td {
      text-transform: uppercase
    }

    .dt-buttons {
      display: none;
    }

    .pull-left ul {
      list-style: none;
      margin: 0;
      padding-left: 0;
    }

    .pull-left a {
      text-decoration: none;
      color: #ffffff;
    }

    .pull-left li {
      color: #ffffff;
      background-color: #2f2f2f;
      border-color: #2f2f2f;
      display: block;
      float: left;
      position: relative;
      text-decoration: none;
      transition-duration: 0.5s;
      padding: 12px 30px;
      font-size: .75rem;
      font-weight: 400;
      line-height: 1.428571;
    }

    .pull-left li:hover {
      cursor: pointer;
    }

    .pull-left ul li ul {
      visibility: hidden;
      opacity: 0;
      min-width: 9.2rem;
      position: absolute;
      transition: all 0.5s ease;
      margin-top: 8px;
      left: 0;
      display: none;
    }

    .pull-left ul li:hover>ul,
    .pull-left ul li ul:hover {
      visibility: visible;
      opacity: 1;
      display: block;
    }

    .pull-left ul li ul li {
      clear: both;
      width: 100%;
      color: #ffffff;
    }

    .ul-dropdown {
      margin: 0.3125rem 1px !important;
      outline: 0;
    }

    .firstli {
      border-radius: 0.2rem;
    }

    .firstli .material-icons {
      position: relative;
      display: inline-block;
      top: 0;
      margin-top: -1.1em;
      margin-bottom: -1em;
      font-size: 0.8rem;
      vertical-align: middle;
      margin-right: 5px;
    }
  </style>
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="file-text"></i></div>
              Data SPL
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
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="pull-right">
              <div class="pull-left float-end">
                <nav role="navigation">
                  <ul class="ul-dropdown">
                    <li class="firstli">
                      <i class="material-icons">Export</i><a href="#">data tabel</a>
                      <ul>
                        <li><a href="#">Export CSV</a></li>
                        <li><a href="#">Export Excel</a></li>
                        <li><a href="#">Export PDF</a></li>
                        <li><a href="#">Print</a></li>
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
          <div class="card-body" style="overflow-x: auto;">
            <table id="data-table-lembur" class="table table-hover">
              <div class="row gx-3 mb-3">
                <div class="col-md-4 mb-3">
                  <select name="status_hrd" class="form-select" id="tipe_lembur">
                    <option value="" selected>- Pilih Tipe Lembur -</option>
                    <option value="1">Tanggal Merah</option>
                    <option value="2">OFF</option>
                    <option value="3">Kelebihan Jam</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <select name="departemen" class="form-select" id="departemen">
                    <option value="" selected>- Pilih Departemen -</option>
                    @foreach($dept as $row)
                    <option value="{{ $row->id }}">{{ $row->departemen }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <select name="divisi" class="form-select" id="divisi">
                    <option value="" selected>- Pilih Divisi -</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <input type="month" name="periode_pengajuan" class="form-control sm" id="periode_pengajuan" placeholder="">
                </div>
                <div class="col-md-4 mb-3">
                  <select name="status_hrd" class="form-select" id="tipe_lembur">
                    <option value="" selected>- Status karyawan -</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Ditolak">Ditolak</option>
                  </select>
                </div>
                <div class="col-md-4 mb-3">
                  <select name="status_hrd" class="form-select" id="tipe_lembur">
                    <option value="" selected>- Status HOD -</option>
                    <option value="Diterima">Diterima</option>
                    <option value="Menunggu">Menunggu</option>
                    <option value="Ditolak">Ditolak</option>
                  </select>
                </div>
              </div>
              <hr>
              <thead>
                <tr>
                  <th>NIK</th>
                  <th>Nama</th>
                  <th>Mulai</th>
                  <th>Berakhir</th>
                  <th>Total Jam</th>
                  <th>Tipe Lembur</th>
                  <th>Karyawan</th>
                  <th>HOD</th>
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

  <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

  <script>
    $(function() {

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var table = $('#data-table-lembur').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        dom: "Blfrtip",
        buttons: [{
            text: 'csv',
            extend: 'csvHtml5',
            exportOptions: {
              columns: ':visible:not(.not-export-col)'
            }
          },
          {
            text: 'excel',
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible:not(.not-export-col)'
            }
          },
          {
            text: 'pdf',
            extend: 'pdfHtml5',
            exportOptions: {
              columns: ':visible:not(.not-export-col)'
            }
          },
          {
            text: 'print',
            extend: 'print',
            exportOptions: {
              columns: ':visible:not(.not-export-col)'
            }
          },
        ],
        ajax: {
          url: "/kompensasi-dan-keuntungan/lembur/list",
          data: function(d) {
            d.tipe_lembur = $('#tipe_lembur').val(),
              d.periode_pengajuan = $('#periode_pengajuan').val(),
              d.departemen = $('#departemen').val()
            d.nama_divisi = $('#divisi').val()
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
            data: 'mulai_lembur',
            name: 'mulai_lembur'
          },
          {
            data: 'berakhir_lembur',
            name: 'berakhir_lembur'
          },
          {
            data: 'selisih_lembur',
            name: 'selisih_lembur'
          },
          {
            data: 'tipe_lembur',
            name: 'tipe_lembur',
            render: function(data, type, row) {
              badge = '';
              if (data == 1) {
                badge = '<span class="badge bg-danger">' + "Tanggal Merah" + '</span>';
              }
              if (data == 2) {
                badge = '<span class="badge bg-primary">' + "OFF" + '</span>';
              }
              if (data == 3) {
                badge = '<span class="badge bg-secondary">' + "Kelebihan Jam" + '</span>';
              }
              return badge;
            }
          },
          {
            data: 'persetujuan_karyawan',
            name: 'persetujuan_karyawan',
            render: function(data, type, row) {
              badge = '';
              switch (data) {
                case 'Diterima':
                  badge = '<span class="badge bg-success">' + data + '</span>';
                  break;
                case 'Ditolak':
                  badge = '<span class="badge bg-red">' + data + '</span>';
                  break;
                case 'Menunggu':
                  badge = '<span class="badge bg-warning">' + data + '</span>';
                  break;

              }
              return badge;
            }
          },
          {
            data: 'persetujuan_hod',
            name: 'persetujuan_hod',
            render: function(data, type, row) {
              badge = '';
              switch (data) {
                case 'Diterima':
                  badge = '<span class="badge bg-success">' + data + '</span>';
                  break;
                case 'Ditolak':
                  badge = '<span class="badge bg-red">' + data + '</span>';
                  break;
                case 'Menunggu':
                  badge = '<span class="badge bg-warning">' + data + '</span>';
                  break;

              }
              return badge;
            }
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

      $('#tipe_lembur').change(function() {
        table.draw();
      });

      $('#periode_pengajuan').change(function() {
        table.draw();
      });

      $('#departemen').change(function() {
        table.draw();
      });

      $('#divisi').change(function() {
        table.draw();
      });

      $("ul li ul li").click(function() {
        var i = $(this).index() + 1
        var table = $('#data-table-lembur').DataTable();
        if (i == 1) {
          table.button('.buttons-csv').trigger();
        } else if (i == 2) {
          table.button('.buttons-excel').trigger();
        } else if (i == 3) {
          table.button('.buttons-pdf').trigger();
        } else if (i == 4) {
          table.button('.buttons-print').trigger();
        }
      });
    });

    document.querySelectorAll('a.toggle-vis').forEach((el) => {
      el.addEventListener('click', function(e) {
        e.preventDefault();

        let columnIdx = e.target.getAttribute('data-column');
        let column = table.column(columnIdx);

        // Toggle the visibility
        column.visible(!column.visible());
      });
    });

    $(document).ready(function() {
      $('#departemen').on('change', function() {
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
                $('#divisi').empty();
                $('#divisi').append('<option hidden>- Pilih Divisi -</option>');
                $.each(data, function(id, divisi) {
                  $('select[name="divisi"]').append('<option value="' + divisi.id + '">' + divisi.nama_divisi + '</option>');
                });
              } else {
                $('#divisi').empty();
              }
            }
          });
        } else {
          $('#divisi').empty();
        }
      });
    });
  </script>
  @endpush
</x-app-layout>
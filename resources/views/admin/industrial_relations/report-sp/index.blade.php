<x-app-layout title="SP Report">
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
              <div class="page-header-icon"><i data-feather="list"></i></div>
              Laporan surat peringatan
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-primary" href="{{ route('spreport.import') }}">
              <i class="me-1" data-feather="upload-cloud"></i>
              Bulk upload
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-fluid px-4">
    <div class="card">
      <div class="card-header">
        <div class="pull-right">
          <div class="pull-left float-end">
            <nav role="navigation">
              <ul class="ul-dropdown">
                <li class="firstli">
                  <i class="material-icons">Export</i><a href="#">data tabel</a>
                  <ul>
                    <li><a href="#">Export Excel</a></li>
                    <li><a href="#">Export CSV</a></li>
                    <li><a href="#">Export PDF</a></li>
                    <li><a href="#">Print</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row gx-3 mb-3">
          <div class="col-md-6 mb-2">
            <label class="small mb-1">Periode peringatan</label>
            <div class="input-group">
              <input type="month" value="" name="periode_sp" id="periode_sp" class="form-control">
            </div>
          </div>
          <div class="col-md-6 mb-2">
            <label class="small mb-1">Level peringatan</label>
            <select name="level_sp" class="form-select" id="level_sp">
              <option value="">- Pilih kategori -</option>
              <option value="SP1">Surat peringatan 1</option>
              <option value="SP2">Surat peringatan 2</option>
              <option value="SP3">Surat peringatan 3</option>
            </select>
          </div>
        </div>
        <table id="data-table-sp" class="table table-hover text-sm" style="width: 100%;">
          <thead>
            <tr>
              <th>No SP</th>
              <th>Nama</th>
              <th>NIK</th>
              <th>Tingkat</th>
              <th>Tanggal mulai</th>
              <th>Tanggal berakhir</th>
              <th>Pelapor</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody> </tbody>
        </table>
      </div>
    </div>
  </div>

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

      var table = $('#data-table-sp').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        dom: "Blfrtip",
        buttons: [{
            text: 'excel',
            extend: 'excelHtml5',
            exportOptions: {
              columns: ':visible:not(.not-export-col)'
            }
          },
          {
            text: 'csv',
            extend: 'csvHtml5',
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
          url: "/industrial-relations/sp-report/serverside",
          data: function(d) {
            d.search = $('input[type="search"]').val();
            d.level_sp = $('#level_sp').val();
            d.periode_sp = $('#periode_sp').val();
          }
        },
        columns: [{
            data: 'no_sp',
            name: 'no_sp'
          },
          {
            data: 'nama_karyawan',
            name: 'nama_karyawan'
          },
          {
            data: 'nik_karyawan',
            name: 'nik_karyawan',
          },
          {
            data: 'level_sp',
            name: 'level_sp',
          },
          {
            data: 'tgl_mulai',
            name: 'tgl_mulai',
          },
          {
            data: 'tgl_berakhir',
            name: 'tgl_berakhir',
          },
          {
            data: 'pelapor',
            name: 'pelapor',
          },
          {
            data: 'action',
            name: 'action',
          },
        ],
        order: [
          [0, 'desc']
        ]
      });

      $('#level_sp').change(function() {
        table.draw();
      });

      $('#periode_sp').change(function() {
        table.draw();
      });

      $("ul li ul li").click(function() {
        var i = $(this).index() + 1
        var table = $('#data-table-karyawan').DataTable();
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
  </script>
  @endpush
</x-app-layout>
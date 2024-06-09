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
          <div class="card-body" style="overflow-x: auto;">
            <table id="data-table-admin-lembur" class="table table-hover">
              <div class="row gx-3 mb-3">
                <div class="col-md-4 mb-3">
                  <select name="status_hrd" class="form-select" id="tipe_lembur">
                    <option value="" selected>- Pilih Tipe Lembur -</option>
                    <option value="1">Tanggal Merah</option>
                    <option value="2">OFF</option>
                    <option value="3">Kelebihan Jam</option>
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
                  <th>Total</th>
                  <th>Tipe Lembur</th>
                  <th>Status</th>
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

  <script>
    $(function() {

      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });

      var table = $('#data-table-admin-lembur').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ajax: {
          url: "/admin/lembur/server-side-lembur",
          data: function(d) {
            d.tipe_lembur = $('#tipe_lembur').val(),
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
              switch (data) {
                case 1:
                  badge = '<span class="badge bg-danger">' + 'Tanggal Merah' + '</span>';
                  break;
                case 2:
                  badge = '<span class="badge bg-primary">' + 'OFF' + '</span>';
                  break;
                case 3:
                  badge = '<span class="badge bg-secondary">' + 'Kelebihan Jam' + '</span>';
                  break;
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
    });
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
  @endpush
</x-app-layout>
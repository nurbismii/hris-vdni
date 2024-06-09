<x-app-layout title="Buat SPL">

  @push('styles')
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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
  <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" />
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

  <style>
    span.select2.select2-container.select2-container--classic {
      width: 100% !important;
    }
  </style>
  @endpush

  <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
    <div class="container-xl px-4">
      <div class="page-header-content pt-4">
        <div class="row align-items-center justify-content-between">
          <div class="col-auto mt-4">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="user-plus"></i></div>
              Pengajuan SPL
            </h1>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-42 mt-n10">
    <!-- Wizard card example with navigation-->
    <div class="card">
      <div class="card-body">
        <div class="tab-content" id="cardTabContent">
          <!-- Wizard tab pane item 1-->
          <div class="row justify-content-center">
            <div class="col-xxl-6 col-xl-8">
              <h3 class="text-primary text-center">Formulir Pengajuan SPL</h3>
              <div class="table-responsive">
                <table class="table table-borderless">
                  <tbody>
                    <tr>
                      <th width="20px">Departemen</th>
                      <td width="10px">:</td>
                      <td width="">{{ Auth::user()->employee->divisi->departemen->departemen }}</td>
                    </tr>
                    <tr>
                      <th width="20px">Divisi</th>
                      <td width="10px">:</td>
                      <td width="">{{ Auth::user()->employee->divisi->nama_divisi }}</td>
                    </tr>
                    <tr>
                      <th width="20px">Hari/Tanggal</th>
                      <td width="10px">:</td>
                      <td width="">{{ date('d-M-Y', strtotime(now())) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <form action="{{ route('store.lembur') }}" method="post" enctype="application/x-www-form-urlencoded">
                @csrf
                <div class="mb-3">
                  <select class="form-select search" name="search" id="nik"></select>
                  <input type="hidden" class="form-control" name="dept_id" value="{{ Auth::user()->employee->divisi->departemen->id }}"></input>
                  <input type="hidden" class="form-control" name="div_id" value="{{ Auth::user()->employee->divisi->id }}"></input>
                  <input type="hidden" class="form-control" name="tanggal_pengajuan" value="{{ date('Y-m-d', strtotime(now())) }}"></input>
                </div>
                <div class="row gx-3">
                  <div class="mb-3 col-md-6">
                    <label class="small mb-1" for="nama">Nama</label>
                    <input class="form-control" id="nama_karyawan" type="text" readonly required />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="small mb-1" for="nik">NIK</label>
                    <input class="form-control nik_karyawan" type="text" name="nik_karyawan" readonly required />
                  </div>
                </div>
                <div class="row gx-3">
                  <div class="mb-3 col-md-6">
                    <label class="small mb-1" for="departemen">Departemen</label>
                    <input class="form-control" id="departemen" type="text" readonly required />
                  </div>
                  <div class="mb-3 col-md-6">
                    <label class="small mb-1" for="divisi">Divisi</label>
                    <input class="form-control" id="divisi" type="text" readonly required />
                  </div>
                </div>
                <div class="mb-3">
                  <label class="small mb-1" for="posisi">Posisi</label>
                  <input class="form-control" id="posisi" name="posisi" type="text" readonly required />
                </div>
                <div class="mb-3">
                  <label class="small mb-1" for="posisi">Tipe Lembur</label>
                  <select name="tipe_lembur" class="form-select" id="" required>
                    <option value="" disabled>Pilih Tipe Lembur :</option>
                    <option value="1">SPL Tanggal Merah</option>
                    <option value="2">SPL Off</option>
                    <option value="3">SPL Kelebihan Jam</option>
                  </select>
                </div>
                <div class="row gx-3">
                  <div class="col-md-4 mb-3">
                    <label class="small mb-1" for="berakhir_lembur">Mulai Lembur</label>
                    <input class="form-control" type="text" name="mulai_lembur" id="startTime" placeholder="00.00" required />
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="small mb-1" for="berakhir_lembur">Berakhir lembur</label>
                    <input class="form-control" type="text" name="berakhir_lembur" id="endTime" placeholder="00.00" required />
                  </div>
                  <div class="col-md-4 mb-3">
                    <label class="small mb-1" for="berakhir_lembur">Total Jam</label>
                    <input class="form-control" type="text" name="total_jam" id="totalDuration" readonly />
                  </div>
                  <div class="col-md-12 mb-3 text-end">
                    <a href="#totalDuration" onclick="getValue()" class="btn btn-secondary btn-sm">Hitung Jam Lembur</a>
                  </div>
                </div>
                <div class="mb-3">
                  <label class="small mb-1" for="posisi">Keterangan</label>
                  <textarea class="form-control" id="posisi" type="text" name="keterangan" required> </textarea>
                </div>
                <hr class="my-4" />
                <div class="d-flex justify-content-between">
                  <button class="btn btn-light" type="reset">Batal</button>
                  <button class="btn btn-primary" type="submit">Kirim</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <x-toastr />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
  <script type="text/javascript">
    $('.search').select2({
      width: 'resolve',
      theme: 'classic',
      placeholder: 'Pilih karyawan...',
      ajax: {
        url: '/api/hrcorner/search-employee-div',
        dataType: 'json',
        delay: 250,
        processResults: function(data) {
          return {
            results: $.map(data, function(item) {
              return {
                text: item.nik + ' - ' + item.nama_karyawan,
                id: item.nik
              }
            })
          };
        },
        cache: true
      }
    });

    $('#nik').on('change', function() {
      var id = $(this).val();
      if (id) {
        $.ajax({
          url: '/api/hrcorner/detail-employee/' + id,
          type: "GET",
          data: {
            "_token": "{{ csrf_token() }}"
          },
          dataType: "json",
          success: function(data) {
            if (data) {
              $('.nik_karyawan').val(data.nik);
              $('#nama_karyawan').val(data.nama_karyawan);
              $('#departemen').val(data.departemen);
              $('#divisi').val(data.nama_divisi);
              $('#posisi').val(data.posisi);
              $('#jabatan').val(data.jabatan);
            }
          }
        });
      }
    });

    $("#startTime").datetimepicker({
      format: "HH:mm"
    });

    $("#endTime").datetimepicker({
      format: "HH:mm"
    });

    document.getElementById('startTime').addEventListener('input', function(event) {
      let input = event.target;
      let value = input.value;

      // Jika panjang nilai adalah 4, ubah angka di posisi ketiga menjadi titik
      if (value.length === 4) {
        let valueArray = value.split("");
        valueArray[2] = ".";
        value = valueArray.join("");
        checkHours = value.slice(0, 1);
        checkMinute = value.slice(3, 4);
      }

      if (checkHours > '24') {
        h = "24";
        if (checkMinute > '60') {
          m = "60";
        }
        value = h + '.' + m;
      }
      // Update nilai input
      input.value = value;
    });

    document.getElementById('endTime').addEventListener('input', function(event) {
      let input = event.target;
      let value = input.value;

      // Jika panjang nilai adalah 4, ubah angka di posisi ketiga menjadi titik
      if (value.length === 4) {
        let valueArray = value.split("");
        valueArray[2] = ".";
        value = valueArray.join("");
        checkHours = value.slice(0, 1);
        checkMinute = value.slice(3, 4);
      }

      if (checkHours > '24') {
        h = "24";
        if (checkMinute > '60') {
          m = "60";
        }
        value = h + '.' + m;
      }
      // Update nilai input
      input.value = value;
    });

    function getValue() {
      const startTime = document.getElementById('startTime').value;
      const endTime = document.getElementById('endTime').value;

      if (startTime && endTime) {
        const [startHours, startMinutes] = startTime.split(':').map(Number);
        const [endHours, endMinutes] = endTime.split(':').map(Number);

        const startDate = new Date(0, 0, 0, startHours, startMinutes);
        const endDate = new Date(0, 0, 0, endHours, endMinutes);

        const diff = endDate - startDate;
        const diffHours = Math.floor(diff / 1000 / 60 / 60);
        const diffMinutes = Math.floor((diff / 1000 / 60) % 60);

        document.getElementById('totalDuration').value = `${diffHours} jam ${diffMinutes} menit`;
      } else {
        document.getElementById('totalDuration').value = '';
      }
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/litepicker.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  @endpush

</x-app-layout>
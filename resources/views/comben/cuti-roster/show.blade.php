<x-app-layout title="Cuti Roster">
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
  <!-- Select2 -->
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-xl px-4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="archive"></i></div>
              Cuti Roster Detail
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-blue" href="/roster">
              <i class="me-1" data-feather="x"></i>
              Tutup
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-xl px-4 mt-4">
    <div class="row">
      <div class="col-lg-8">
        <div class="card invoice">
          <div class="card-body p-2 p-md-4">
            <div class="text-center lh-1 mb-2">
              <h4 class="fw-bold">FORMULIR PERMOHONAN CUTI ROSTER</h4> <br>
              @if($data->periode_kerja->tipe_rencana == '1')
              <b>CUTI ROSTER</b>
              @else
              <b>BEKERJA</b>
              @endif
            </div>
            <hr>
            <div class="table-responsive">
              <table class="table table-borderless mb-0">
                <tbody>
                  <tr>
                    <th scope="row">Nomor Induk Karyawan</th>
                    <td>{{$data->nik_karyawan}}</td>
                    <td>Tanggal Pengajuan</td>
                    <td>{{tgl_indo($data->tanggal_pengajuan)}}</td>
                  </tr>
                  <tr>
                    <th scope="row">Nama Karyawan</th>
                    <td>{{ $data->karyawan->nama_karyawan }}</td>
                    <td>Email</td>
                    <td>{{ $data->email }}</td>
                  </tr>
                  <tr>
                    <th scope="row">Departemen</th>
                    <td>{{$data->karyawan->divisi->nama_divisi}}</td>
                    <td>Posisi</td>
                    <td>{{$data->karyawan->posisi}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- Invoice table 1-->

            <div class="row">
              <div class="table-responsive col-lg-12 mb-2">
                <table class="table table-bordered mb-0">
                  <thead class="border-bottom">
                    <tr class="small text-uppercase text-muted">
                      <th scope="col">Periode</th>
                      <th>Tanggal</th>
                      <th>Tipe</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-bottom">
                      <td>I</td>
                      <td class="fw-bold">{{ tgl_indo($data->periode_kerja->tanggal_satu)}}</td>
                      <td>{{ $data->periode_kerja->satu }}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>II</td>
                      <td class="fw-bold">{{ tgl_indo($data->periode_kerja->tanggal_dua)}}</td>
                      <td>{{ $data->periode_kerja->dua }}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>III</td>
                      <td class="fw-bold">{{ tgl_indo($data->periode_kerja->tanggal_tiga)}}</td>
                      <td>{{ $data->periode_kerja->tiga }}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>IV</td>
                      <td class="fw-bold">{{ tgl_indo($data->periode_kerja->tanggal_empat)}}</td>
                      <td>{{ $data->periode_kerja->empat }}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>V</td>
                      <td class="fw-bold">{{ tgl_indo($data->periode_kerja->tanggal_lima)}}</td>
                      <td>{{ $data->periode_kerja->lima }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              @if($data->periode_kerja->tipe_rencana == '1')
              <div class="table-responsive col-lg-12">
                <table class="table table-borderless mb-0">
                  <thead class="border-bottom">
                    <tr class="small text-uppercase text-muted">
                      <th scope="col">Keberangkatan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Cuti Roster</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ tgl_indo($data->tgl_mulai_cuti)}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Cuti tahunan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ $data->tgl_mulai_cuti_tahunan > '2016-04-01' ? tgl_indo($data->tgl_mulai_cuti_tahunan) : ''}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Tanggal mulai off</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ $data->tgl_mulai_off > '2016-04-01' ? tgl_indo($data->tgl_mulai_off) : ''}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Tanggal keberangkatan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ $data->tgl_keberangkatan > '2016-04-01' ? tgl_indo($data->tgl_keberangkatan) : ''}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Waktu keberangkatan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->jam_keberangkatan}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Dari</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->kota_awal_keberangkatan}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Tujuan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->kota_tujuan_keberangkatan}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Catatan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->catatan_penting_keberangkatan}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="table-responsive col-lg-12">
                <table class="table table-borderless mb-0">
                  <thead class="border-bottom">
                    <tr class="small text-uppercase text-muted">
                      <th scope="col">Kepulangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Cuti Roster Berakhir</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ $data->tgl_mulai_cuti_berakhir > '2016-04-01' ? tgl_indo($data->tgl_mulai_cuti_berakhir) : '' }}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Cuti Tahunan Berakhir</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ $data->tgl_mulai_cuti_tahunan_berakhir > '2016-04-01' ? tgl_indo($data->tgl_mulai_cuti_tahunan_berakhir) : '' }}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Tanggal Berakhir Off</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{ $data->tgl_mulai_off_berakhir > '2016-04-01' ? tgl_indo($data->tgl_mulai_off_berakhir) : ''}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Tanggal Kepulangan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{tgl_indo($data->tgl_kepulangan)}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Waktu Kepulangan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->jam_kepulangan}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Dari</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->kota_awal_kepulangan}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Tujuan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->kota_tujuan_kepulangan}}</td>
                    </tr>
                    <tr class="border-bottom">
                      <td>
                        <div class="fw-bold">Catatan</div>
                      </td>
                      <td class="text-end fw-bold">:</td>
                      <td class="text-end fw-bold">{{$data->catatan_penting_keberangkatan}}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              @else
              @php
              $tgl_cuti = new DateTime($data->tgl_awal_kerja);
              $tgl_sekarang = new DateTime($data->tgl_akhir_kerja);
              $tgl_jt_tempo = $tgl_sekarang->diff($tgl_cuti)->days;
              @endphp
              <div class="table-responsive col-lg-12">
                <table class="table table-bordered mb-0">
                  <thead class="border-bottom">
                    <tr class="small text-uppercase text-muted">
                      <th>Tanggal Bekerja Pada Cuti Roster</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="">
                      <td class="fw-bold">{{ tgl_indo($data->tgl_awal_kerja) }} - {{ tgl_indo($data->tgl_akhir_kerja) }}</td>
                      <td class="fw-bold">{{ $tgl_jt_tempo + 1}} Hari</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              @endif
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card mb-4 mb-xl-0">
          <div class="card-header">Status Pengajuan</div>
          <div class="card-body">
            <form action="{{ route('cutiroster.update', $data->id) }}" method="post">
              @csrf
              <label for="" class="mb-1">Persetujuan HOD</label>
              @if($data->status_pengajuan == 'diterima')
              <h5><span class="badge bg-success fw-bold">{{ ucfirst($data->status_pengajuan) }}</span></h5>
              @elseif($data->status_pengajuan == 'ditolak')
              <h5><span class="badge bg-danger">{{ ucfirst($data->status_pengajuan) }}</span></h5>
              @else
              <h5><span class="badge bg-primary">{{ ucfirst($data->status_pengajuan) }}</span></h5>
              @endif
              <label for="" class="mb-2">Persetujuan HR</label>
              <select name="status_pengajuan" class="form-select">
                <option value="{{$data->status_pengajuan_hrd}}">{{ ucfirst($data->status_pengajuan_hrd)}}</option>
                @if($data->status_pengajuan_hrd != 'diterima')
                <option value="diterima">Diterima</option>
                @endif
                @if($data->status_pengajuan_hrd != 'ditolak')
                <option value="ditolak">Ditolak</option>
                @endif
              </select>
              <hr class="my-4" />
              <div class="d-grid">
                <button class="btn btn-primary" type="submit">Perbarui status</button>
              </div>
            </form>
          </div>
        </div>
        <div class="card mb-4 mt-3 mb-xl-0">
          <div class="card-header">Upload tiket</div>
          <div class="card-body">
            <form action="{{ route('cutiroster.upload.tiket', $data->id) }}" enctype="multipart/form-data" method="post">
              @csrf
              <label for="" class="mb-2">Pilih file</label>
              <input type="file" name="tiket_pesawat" class="form-control">
              <hr class="my-4" />
              <div class="mb-3">
                Tiket :
                @if($data->tiket_pesawat != null)
                <a href="{{route('cutiroster.download.tiket', $data->id)}}" target="_blank" rel="noopener noreferrer">{{ substr($data->tiket_pesawat, 0, 35) }}...</a>
                @else
                Tiket belum tersedia
                @endif
              </div>
              <hr class="my-4" />
              <div class="d-grid">
                <button class="btn btn-primary" type="submit">Kirim</button>
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
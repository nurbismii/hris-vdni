<x-app-layout title="Ubah Pengguna">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @endpush

    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Ubah Pengguna
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <!-- Wizard card example with navigation-->
        <div class="card">
            <div class="card-body">
                <div class="tab-content" id="cardTabContent">
                    <div class="tab-pane py-5 py-xl-10 fade show active" id="wizard1" role="tabpanel" aria-labelledby="wizard1-tab">
                        <div class="row justify-content-center">
                            <div class="col-xxl-6 col-xl-8">
                                <h3 class="text-primary text-center">Form Pengguna</h3>
                                <form action="{{ route('update.user', $data->nik_karyawan) }}" method="POST">
                                    @csrf
                                    {{ method_field('patch') }}
                                    <div class="mb-3">
                                        <label class="small mb-1">Nomor Induk Karyawan</label>
                                        <input class="form-control @error('nik_karyawan') is-invalid @enderror" type="text" value="{{ $data->nik_karyawan }}" readonly />
                                        @error('nik_karyawan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="small mb-1">Nama Karyawan</label>
                                        <input class="form-control @error('name') is-invalid @enderror" type="text" value="{{ $data->employee->nama_karyawan }}" readonly />
                                        @error('name')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label class="small mb-1">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" type="email" value="{{ $data->email }}" />
                                        @error('email')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row gx-3 mb-3">
                                        <div class="mb-3 col-md-6">
                                            <label class="small mb-1">Kata Sandi</label>
                                            <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="*****" />
                                            @error('password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="mb-3 col-md-6">
                                            <label class="small mb-1">Konfirmasi Kata Sandi</label>
                                            <input class="form-control @error('konfirmasi_password') is-invalid @enderror" name="konfirmasi_password" type="password" placeholder="*****" />
                                            @error('konfirmasi_password')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="small mb-1">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="{{ $data->status }}" selected>{{ ucfirst($data->status) }}</option>
                                            @if(strtolower($data->status) == 'tidak aktif')
                                            <option value="aktif">Aktif</option>
                                            @else
                                            <option value="tidak aktif">Tidak aktif</option>
                                            @endif
                                        </select>
                                    </div>
                                    <hr class="my-4" />
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ url()->previous() }}" class="btn btn-light" type="button">Kembali</a>
                                        <button class="btn btn-primary" type="submit">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
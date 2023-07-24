<x-app-layout title="Tambah Pengguna">
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
                            Pengguna
                        </h1>
                        <div class="page-header-subtitle">Pengguna bisa ditambahkan jika telah terdaftar sebagai karyawan</div>
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
                    <form action="/users/store" method="POST">
                        @csrf
                        <div class="tab-pane py-5 py-xl-10 fade show active" id="wizard1" role="tabpanel" aria-labelledby="wizard1-tab">
                            <div class="row justify-content-center">
                                <div class="col-xxl-6 col-xl-8">
                                    <h3 class="text-primary">Form Pengguna</h3>
                                    <h5 class="card-title mb-4">Masukkan data pribadi pengguna</h5>
                                    <form>
                                        <div class="mb-3">
                                            <label class="small mb-1">NIK</label>
                                            <input class="form-control" type="text" name="nik_karyawan" placeholder="NIK Karyawan" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1">Email</label>
                                            <input class="form-control" name="email" type="email" placeholder="Email" />
                                        </div>
                                        <div class="row gx-3">
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1">Kata Sandi</label>
                                                <input class="form-control" name="password" type="password" placeholder="Kata Sandi" />
                                            </div>
                                            <div class="mb-3 col-md-6">
                                                <label class="small mb-1">Konfirmasi Kata Sandi</label>
                                                <input class="form-control" name="password_confirm" type="password" placeholder="Konfirmasi Kata Sandi" />
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1">Status</label>
                                            <select class="form-select" name="status">
                                                <option selected disabled>Pilih status : </option>
                                                <option value="aktif">Aktif</option>
                                                <option value="tidak aktif">Tidak Aktif</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small mb-1">Posisi</label>
                                            <select class="form-select" name="role_id" aria-label="Default select example">
                                                <option selected disabled>Pilih posisi :</option>
                                                @foreach($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->permission_role }}</option>
                                                @endforeach
                                                <option value="">User</option>
                                            </select>
                                        </div>
                                        <hr class="my-4" />
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ url()->previous() }}" class="btn btn-light" type="button">Kembali</a>
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
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
<x-auth-layout title="Daftar">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    @endpush

    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="mt-4">
                    <x-message />
                </div>
                <div class="card-opacation shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header text-center">
                        <h3 class="fw-bold my-2 text-white">Pendaftaran akun</h3>
                        <img src="{{ asset('assets/img/backgrounds/icon.png') }}" class="text-center" style="height: 55px;" alt="">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.employee') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1 text-white">Nomor Induk Karyawan</label>
                                <input class="form-control-login @error('employee_id') is-invalid @enderror" type="number" name="employee_id" placeholder="Masukkan NIK" />
                                @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-white">Email</label>
                                <input class="form-control-login @error('email') is-invalid @enderror" type="email" name="email" placeholder="contoh@gmail.com" />
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-white">Kata sandi</label>
                                <input class="form-control-login @error('password') is-invalid @enderror" type="password" name="password" placeholder="******" />
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-white">Konfirmasi kata sandi</label>
                                <input class="form-control-login @error('password_confirm') is-invalid @enderror" name="password_confirm" type="password" placeholder="******" />
                                @error('password_confirm')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center d-grid">
                                <button type="submit" class="btn btn-success">Daftar</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small text-white">Sudah punya akun! <a class="text-primary bold" href="/login"> Masuk</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js')}}"></script>
    @endpush
</x-auth-layout>
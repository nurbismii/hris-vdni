<x-auth-layout title="Daftar">
    @push('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>

    <style>
        body {
            background: #f4f7fc;
        }

        .auth-card {
            border-radius: 1rem;
        }

        .input-group-text {
            background: #f8f9fa;
        }
    </style>
    @endpush

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-6 col-lg-4">

            <x-message />

            <div class="card auth-card shadow border-0">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="text-center mb-4">
                        <img src="{{ asset('assets/img/backgrounds/icon.png') }}" height="50" class="mb-2">
                        <h4 class="fw-bold">Pendaftaran Akun</h4>
                        <p class="text-muted small">Silakan lengkapi data di bawah</p>
                    </div>

                    <!-- Form -->
                    <form action="{{ route('register.employee') }}" method="POST">
                        @csrf

                        <!-- NIK -->
                        <div class="mb-3">
                            <label class="form-label small">Nomor Induk Karyawan</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-id-card"></i>
                                </span>
                                <input type="number"
                                    name="employee_id"
                                    class="form-control @error('employee_id') is-invalid @enderror"
                                    placeholder="Masukkan NIK">
                            </div>
                            @error('employee_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="contoh@gmail.com">
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label small">Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="••••••••">
                                <button class="btn btn-light border-0 rounded-end" type="button" onclick="togglePassword('password','eye1')">
                                    <i class="fa-solid fa-eye" id="eye1"></i>
                                </button>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label class="form-label small">Konfirmasi Kata Sandi</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password"
                                    id="password_confirm"
                                    name="password_confirm"
                                    class="form-control @error('password_confirm') is-invalid @enderror"
                                    placeholder="••••••••">
                                <button class="btn btn-light border-0 rounded-end" type="button" onclick="togglePassword('password_confirm','eye2')">
                                    <i class="fa-solid fa-eye" id="eye2"></i>
                                </button>
                            </div>
                            @error('password_confirm')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fa-solid fa-user-plus me-1"></i> Daftar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-transparent border-0 text-center pb-4">
                    <span class="small">
                        Sudah punya akun?
                        <a href="/login" class="fw-semibold text-decoration-none">Masuk</a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword(fieldId, iconId) {
            const input = document.getElementById(fieldId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
</x-auth-layout>
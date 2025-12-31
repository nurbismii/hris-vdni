<x-auth-layout title="Masuk">
    @push('styles')
    <style>
        .card {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" crossorigin="anonymous"></script>
    @endpush

    <div class="container min-vh-100 d-flex align-items-center justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">

                    <!-- Title -->
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Selamat Datang 👋</h4>
                        <p class="text-muted small mb-0">Silakan masuk ke akun Anda</p>
                    </div>

                    <!-- Login Form -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label class="form-label small">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email"
                                    name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="contoh@email.com"
                                    required>
                            </div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label class="form-label small">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password"
                                    name="password"
                                    id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="••••••••"
                                    required>
                                <button class="btn btn-light border-0 rounded-end"
                                    type="button"
                                    onclick="togglePassword()">
                                    <i class="fa-solid fa-eye" id="eyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Forgot Password -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <a href="/lupa-kata-sandi" class="small text-decoration-none">
                                Lupa kata sandi?
                            </a>
                        </div>

                        <!-- Submit -->
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary rounded-pill">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Masuk
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="card-footer bg-transparent text-center border-0 pb-4">
                    <span class="small">
                        Belum punya akun?
                        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">
                            Daftar sekarang
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (password.type === 'password') {
                password.type = 'text';
                eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                password.type = 'password';
                eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    @endpush
</x-auth-layout>
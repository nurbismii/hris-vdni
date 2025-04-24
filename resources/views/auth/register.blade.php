<x-auth-layout title="Daftar">
    @push('styles')
    <<link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style>
        /* Your custom styles */
        body {
            background-color: #f4f7fc;
            font-family: 'Roboto', sans-serif;
        }

        a {
            color: #1a73e8;
            text-decoration: none;
        }

        .form-control-login {
            border-radius: 0.375rem;
            border: 1px solid #e3e6f0;
            padding: 0.75rem 1rem;
            background-color: #fff;
        }

        .form-control-login:focus {
            box-shadow: 0 0 0 0.2rem rgba(58, 123, 253, 0.25);
        }

        .card {
            border: none;
            border-radius: 0.75rem;
        }

        .card-header {
            background-color: transparent;
            border-bottom: none;
        }

        .btn-success {
            background-color: #1a73e8;
            border: none;
            border-radius: 0.375rem;
            padding: 0.75rem;
        }

        .btn-success:hover {
            background-color: #1765c5;
        }

        .small {
            color: #6b7280;
        }

        .small a {
            color: #1a73e8;
            text-decoration: none;
        }

        .small a:hover {
            text-decoration: underline;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .input-group-joined {
            position: relative;
        }

        .input-group-joined .form-control-login {
            padding-right: 2.5rem;
        }

        .input-group-joined .toggle-password {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
    @endpush

    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="mt-4">
                    <x-message />
                </div>
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header text-center">
                        <h3 class="fw-bold mb-0">Pendaftaran Akun</h3>
                        <img src="{{ asset('assets/img/backgrounds/icon.png') }}" class="mt-3" style="height: 50px;" alt="Logo">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.employee') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1">Nomor Induk Karyawan</label>
                                <input class="form-control @error('employee_id') is-invalid @enderror" type="number" name="employee_id" placeholder="Masukkan NIK" />
                                @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="contoh@gmail.com" />
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1">Kata sandi</label>
                                <div class="form-group">
                                    <div class="input-group input-group-joined" id="show_hide_password">
                                        <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" id="password-input" />
                                        <span class="input-group-text toggle-password" style="cursor:pointer; background-color: transparent;">
                                            <i class="fa fa-eye" id="toggle-icon" style="font-size: 14px;"></i>
                                        </span>
                                    </div>
                                </div>
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="small mb-1">Konfirmasi kata sandi</label>
                                <div class="form-group">
                                    <div class="input-group input-group-joined" id="show_hide_password_confirm">
                                        <input class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirm" type="password" id="password-input-confirm" />
                                        <span class="input-group-text toggle-password" style="cursor:pointer; background-color: transparent;">
                                            <i class="fa fa-eye" id="toggle-confirm-icon" style="font-size: 14px;"></i>
                                        </span>
                                    </div>
                                </div>
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
                        <div class="small">Sudah punya akun? <a class="text-primary bold" href="/login"> Masuk</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            // Attach event listener to the span or icon
            $("#show_hide_password .toggle-password").on('click', function() {
                // Get the password input field
                var passwordInput = $('#password-input');
                var toggleIcon = $('#toggle-icon');

                // Check the current type of the input field
                if (passwordInput.attr("type") === "password") {
                    // Change to text to show password
                    passwordInput.attr("type", "text");
                    // Change icon to eye-slash
                    toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    // Change back to password
                    passwordInput.attr("type", "password");
                    // Change icon back to eye
                    toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });

            $("#show_hide_password_confirm .toggle-password").on('click', function() {
                // Get the password input field
                var passwordInput = $('#password-input-confirm');
                var toggleIcon = $('#toggle-icon-confirm');

                // Check the current type of the input field
                if (passwordInput.attr("type") === "password") {
                    // Change to text to show password
                    passwordInput.attr("type", "text");
                    // Change icon to eye-slash
                    toggleIcon.removeClass("fa-eye").addClass("fa-eye-slash");
                } else {
                    // Change back to password
                    passwordInput.attr("type", "password");
                    // Change icon back to eye
                    toggleIcon.removeClass("fa-eye-slash").addClass("fa-eye");
                }
            });
        });
    </script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @endpush
</x-auth-layout>
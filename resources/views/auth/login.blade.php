<x-auth-layout title="Masuk">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Roboto', sans-serif;
        }

        a {
            color:rgb(23, 201, 23);
            text-decoration: none;
        }

        .form-control-login {
            border-radius: 0.375rem;
            border: 1px solid #e3e6f0;
            padding: 0.75rem 1rem;
            background-color: #fff;
        }

        .form-control-login:focus {
            box-shadow: 0 0 0 0.2rem rgba(31, 98, 233, 0.3);
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
            background-color:rgb(23, 201, 23);
            border: none;
            border-radius: 0.375rem;
            padding: 0.75rem;
        }

        .btn-success:hover {
            background-color: rgb(23, 201, 23);
        }

        .small {
            color: #6b7280;
        }

        .small a {
            color: rgb(23, 201, 23);
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
                <div class="card shadow-sm border-0 rounded-lg mt-5">
                    <div class="card-header text-center">
                        <h3 class="fw-bold mb-0">Masuk</h3>
                        <img src="{{ asset('assets/img/backgrounds/icon.png') }}" class="mt-3" style="height: 50px;" alt="Logo">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="small mb-1">Email</label>
                                <input class="form-control-login @error('email') is-invalid @enderror" type="email" name="email" required />
                            </div>
                            <div class="mb-4">
                                <div class="form-group">
                                    <label class="small mb-1">Password</label>
                                    <div class="input-group input-group-joined" id="show_hide_password">
                                        <input class="form-control-login @error('password') is-invalid @enderror" name="password" type="password" id="password-input" />
                                        <span class="input-group-text toggle-password" style="cursor:pointer; background-color: transparent;">
                                            <i class="fa fa-eye" id="toggle-icon" style="font-size: 14px;"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <a class="small" href="/lupa-kata-sandi">Lupa kata sandi?</a>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Masuk</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small">Karyawan baru? <a class="fw-bold" href="{{ route('register') }}">Daftar sekarang!</a></div>
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
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    @endpush
</x-auth-layout>
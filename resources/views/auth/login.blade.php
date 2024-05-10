<x-auth-layout title="Masuk">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <style>
        a {
            color: #79818d;
            text-decoration: none;
        }
    </style>
    @endpush
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="mt-4">
                    <x-message />
                </div>
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header text-center">
                        <h3 class="fw-light my-2">Masuk</h3>
                        <img src="{{ asset('assets/img/backgrounds/icon.png') }}" class="text-center" style="height: 55px;" alt="">
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" />
                            </div>
                            <div class="mb-3">
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group input-group-joined" id="show_hide_password">
                                        <input class="form-control pe-0 @error('password') is-invalid @enderror" name="password" type="password" aria-label="Search">
                                        <span class="input-group-text" style="background-color: #F5F5F5;">
                                            <a href=""><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-2 mb-3">
                                <a class="small" href="/lupa-kata-sandi">Lupa kata sandi ?</a>
                            </div>
                            <div class="text-center d-grid">
                                <button type="submit" class="btn btn-success">Masuk</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small">Karyawan baru ? <a class="text-primary bold" href="{{ route('register') }}">Daftar sekarang!</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function() {
            $("#show_hide_password a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    @endpush
</x-auth-layout>
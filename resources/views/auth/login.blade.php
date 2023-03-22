<x-auth-layout title="Login">
    @push('styles')
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    @endpush
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card-opacation shadow-lg border-0 rounded-lg mt-5">
                    <x-message />
                    <div class="card-header justify-content-center">
                        <h3 class="fw-light my-4 text-light fw-600">Login</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Email</label>
                                <input class="form-control" type="email" name="email" placeholder="Enter email" />
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Password</label>
                                <input class="form-control" type="password" name="password" placeholder="Enter password" />
                            </div>
                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                <a class="small text-light fw-600" href="#">Forgot Password?</a>
                                <button type="submit" class="btn btn-success lift lift-sm text-light fw-600">Login</a>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small text-light fw-600"><a href="{{ route('register') }}">Need an account? Sign up!</a></div>
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
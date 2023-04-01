<x-auth-layout title="Register">
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
                        <h3 class="fw-light my-4 text-light">Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.employee') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1 text-light">NIK</label>
                                <input class="form-control-login @error('employee_id') is-invalid @enderror" type="number" name="employee_id" placeholder="Enter your NIK" />
                                @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light">Email</label>
                                <input class="form-control-login @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter your email" />
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light">Password</label>
                                <input class="form-control-login @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter password" />
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light">Password Confirm</label>
                                <input class="form-control-login @error('password_confirm') is-invalid @enderror" name="password_confirm" type="password" placeholder="Enter your password confirm" />
                                @error('password_confirm')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="text-center d-grid">
                                <button type="submit" class="btn btn-success text-light">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small text-light"><a class="text-light" href="/login">Already have an account? Sign in!</a></div>
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
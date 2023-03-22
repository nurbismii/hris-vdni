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
                        <h3 class="fw-light my-4 text-light fw-600">Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.employee') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" placeholder="Enter your name" />
                                @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">NIK</label>
                                <input class="form-control @error('employee_id') is-invalid @enderror" type="number" name="employee_id" placeholder="Enter your NIK" />
                                @error('employee_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">No KTP</label>
                                <input class="form-control @error('no_ktp') is-invalid @enderror" type="number" name="no_ktp" placeholder="Enter your No KTP" />
                                @error('no_ktp')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">No NPWP</label>
                                <input class="form-control @error('no_npwp') is-invalid @enderror" type="number" name="no_npwp" placeholder="Enter your No NPWP" />
                                @error('no_npwp')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Email</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Enter your email" />
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Date of Birth</label>
                                <input class="form-control @error('date_of_birth') is-invalid @enderror" type="date" name="date_of_birth" placeholder="Enter your birthday" />
                                @error('date_of_birth')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Password</label>
                                <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Enter password" />
                                @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <!-- <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">PASSWORD CONFIRM</label>
                                <input class="form-control" type="password" placeholder="Enter your password confirm" />
                                @error('password_confirm')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div> -->
                            <div class="text-center d-grid">
                                <button type="submit" class="btn btn-success text-light fw-600">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <div class="small text-light fw-600"><a href="/login">Already have an account? Sign in!</a></div>
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
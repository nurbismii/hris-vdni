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
                <x-message />
                <div class="card-opacation shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header justify-content-center">
                        <h3 class="fw-light my-4 text-light fw-600">Register</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register.employee') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">Name</label>
                                <input class="form-control" type="text" name="name" placeholder="Enter your name" />
                                @error('name')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">NIK</label>
                                <input class="form-control" type="number" name="employee_id" placeholder="Enter your NIK" />
                                @error('employee_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">NO KTP</label>
                                <input class="form-control" type="number" name="no_ktp" placeholder="Enter your No KTP" />
                                @error('no_ktp')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">NO NPWP</label>
                                <input class="form-control" type="number" name="no_npwp" placeholder="Enter your No NPWP" />
                                @error('no_npwp')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">EMAIL</label>
                                <input class="form-control" type="email" name="email" placeholder="Enter your email" />
                                @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">DATE OF BIRTH</label>
                                <input class="form-control" type="date" name="date_of_birth" placeholder="Enter your birthday" />
                                @error('date_of_birth')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1 text-light fw-600">PASSWORD</label>
                                <input class="form-control" type="password" name="password" placeholder="Enter password" />
                                @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
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
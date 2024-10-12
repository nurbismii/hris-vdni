<x-auth-layout title="Lupa Kata Sandi">
  @push('styles')
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
  <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
  <style>
    body {
      background-color: #f4f7fc;
      font-family: 'Roboto', sans-serif;
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

    .btn-success {
      background-color: #1a73e8;
      border: none;
      border-radius: 0.375rem;
      padding: 0.75rem;
    }

    .btn-success:hover {
      background-color: #1765c5;
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
            <h3 class="fw-bold mb-0">Lupa Kata Sandi</h3>
            <img src="{{ asset('assets/img/backgrounds/icon.png') }}" class="mt-3" style="height: 50px;" alt="Logo">
          </div>
          <div class="card-body">
            <form action="{{ route('reset.password') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label class="small mb-1">Email</label>
                <input class="form-control-login @error('email') is-invalid @enderror" type="email" name="email" placeholder="Masukkan Email" required />
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
              </div>
              <div class="text-center d-grid">
                <button type="submit" class="btn btn-success">Kirim</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <div class="small">Sudah punya akun? <a class="text-primary bold" href="/login">Masuk</a></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  @endpush
</x-auth-layout>

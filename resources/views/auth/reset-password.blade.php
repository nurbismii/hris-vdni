<x-auth-layout title="Reset kata sandi">
  @push('styles')
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
  <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
  @endpush
  <div class="container-xl px-4">
    <div class="row justify-content-center">
      <div class="col-lg-5">
        <div class="mt-4">
          <x-message />
        </div>
        <div class="card shadow-lg border-0 rounded-lg mt-5">
          <div class="card-header text-center">
            <h3 class="fw-light my-2">Reset kata sandi</h3>
            <img src="{{ asset('assets/img/backgrounds/icon.png') }}" class="text-center" style="height: 55px;" alt="">
          </div>
          <div class="card-body">
            <form action="{{ route('update.password', $user->id) }}" method="POST">
              @csrf
              {{ method_field('patch') }}
              <div class="mb-3">
                <label class="small mb-1">Kata sandi</label>
                <input class="form-control-login @error('password') is-invalid @enderror" type="password" name="password" placeholder="Kata sandi" />
              </div>
              <div class="mb-3">
                <label class="small mb-1">Konfirmasi kata sandi</label>
                <input class="form-control-login @error('repeat_password') is-invalid @enderror" type="password" name="repeat_password" placeholder="Konfimasi kata sandi" />
              </div>
              <div class="text-center d-grid">
                <button type="submit" class="btn btn-success">Simpan</button>
              </div>
            </form>
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
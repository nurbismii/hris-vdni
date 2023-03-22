@if ($message = Session::get('success'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
  <h6 class="alert-heading">Success</h6>
  {{ $message }}
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif


@if ($message = Session::get('error'))

<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <h6 class="alert-heading">Failed</h6>
  {{ $message }}
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif


@if ($message = Session::get('warning'))

<div class="alert alert-success alert-dismissible fade show" role="alert">
  <h6 class="alert-heading">Warning</h6>
  {{ $message }}
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

@endif


@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
  <h6 class="alert-heading">Information</h6>
  {{ $message }}
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <h6 class="alert-heading">Something wrong!</h6>
  @foreach($errors->all() as $error)
  {{ $error }} <br>
  @endforeach
  <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
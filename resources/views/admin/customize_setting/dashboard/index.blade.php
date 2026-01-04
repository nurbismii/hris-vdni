<x-app-layout title="Setting Dashboad">
  @push('styles')
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
  <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
  <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  @endpush

  <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
    <div class="container-fluid px-s4">
      <div class="page-header-content">
        <div class="row align-items-center justify-content-between pt-3">
          <div class="col-auto mb-3">
            <h1 class="page-header-title">
              <div class="page-header-icon"><i data-feather="list"></i></div>
              Content dashboard list
            </h1>
          </div>
          <div class="col-12 col-xl-auto mb-3">
            <a class="btn btn-sm btn-light text-primary" data-bs-toggle="modal" data-bs-target="#addContent">
              <i class="me-1" data-feather="user-plus"></i>
              Add Content Dashboard
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>
  <!-- Main page content-->
  <div class="container-fluid px-4">
    <x-message />
    <div class="card">
      <div class="card-body" style="overflow-x: auto;">
        <table id="datatablesSimple">
          <thead>
            <tr>
              <th>Title</th>
              <th>Sub Title</th>
              <th>Description</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($datas as $data)
            <tr>
              <td>{{ $data->title }}</td>
              <td>{{ $data->subtitle }}</td>
              <td>{{ $data->description }}</td>
              <td>{{ $data->status == '1' ? 'Active' : 'Not Active' }}</td>
              <td>
                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#editContent{{$data->id}}"><i data-feather="edit"></i></a>
                <a type="submit" class="btn btn-datatable btn-icon btn-transparent-dark" data-bs-toggle="modal" data-bs-target="#deleteContent{{$data->id}}"><i data-feather="trash-2"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="addContent" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Content</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('dashboard-widgets.store') }}" method="POST" class="nav flex-column" id="stickyNav">
          <div class="modal-body">
            @csrf
            <div class="mb-3">
              <label class="small mb-1">Title</label>
              <input type="text" name="title" class="form-control">
            </div>
            <div class="mb-3">
              <label class="small mb-1">Subtitle</label>
              <input type="text" name="subtitle" class="form-control">
            </div>
            <div class="mb-3">
              <label class="small mb-1">Description</label>
              <textarea name="description" class="form-control" cols="30" rows="10"></textarea>
            </div>
            <div class="mb-3">
              <label class="small mb-1">Status</label>
              <select name="status" class="form-select">
                <option value="1">Enable</option>
                <option value="0">Disable</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @foreach($datas as $data)
  <div class="modal fade" id="deleteContent{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Delete Content</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('dashboard-widgets.destroy', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
          <div class="modal-body">
            @csrf
            {{ method_field('delete') }}
            Are you sure you want to delete this data ({{ $data->title }})?
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach

  @foreach($datas as $data)
  <div class="modal fade" id="editContent{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Content</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{ route('dashboard-widgets.update', $data->id) }}" method="POST" class="nav flex-column" id="stickyNav">
          @csrf
          {{ method_field('patch') }}
          <div class="modal-body">
            <div class="mb-3">
              <label class="small mb-1">Title</label>
              <input type="text" name="title" class="form-control" value="{{ $data->title }}">
            </div>
            <div class="mb-3">
              <label class="small mb-1">Subtitle</label>
              <input type="text" name="subtitle" class="form-control" value="{{ $data->subtitle }}">
            </div>
            <div class="mb-3">
              <label class="small mb-1">Description</label>
              <textarea name="description" class="form-control" cols="30" rows="10">{{ $data->description }}</textarea>
            </div>
            <div class="mb-3">
              <label class="small mb-1">Status</label>
              <select name="status" class="form-select">
                <option value="{{ $data->status }}">{{ $data->status == '1' ? 'Active' : 'Not Active' }}</option>
                @if($data->status == '1')
                <option value="0">Not Active</option>
                @else
                <option value="1">Active</option>
                @endif
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="submit">Add</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach

  @push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/scripts.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="{{ asset('js/datatables/datatables-simple-demo.js')}}"></script>
  <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
  <script src="{{ asset('js/litepicker.js')}}"></script>
  <script src="{{ asset('js/app.js')}}"></script>
  @endpush
</x-app-layout>
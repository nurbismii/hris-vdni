<x-app-layout title="Create-Role">
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
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Add Role
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="/roles">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Role List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>Permission Role</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Administrator</td>
                                    <td>administrator all access</td>
                                    <td>Active</td>
                                    <td>20 Jun 2021</td>
                                </tr>
                                <tr>
                                    <td>administrator all access</td>
                                    <td>Active</td>
                                    <td>20 Jun 2021</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="nav-sticky">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">New Role</div>
                        <div class="card-body">
                            <form action="" enctype="application/x-www-form-urlencoded" class="nav flex-column" id="stickyNav">
                                <div class="mb-3">
                                    <label class="small mb-1">Role</label>
                                    <input class="form-control" type="email" placeholder="Enter your email address" value="" />
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1">Description</label>
                                    <textarea class="form-control" name="description" cols="30" rows="10"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1">Status</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected disabled>Select a role:</option>
                                        <option value="active">Active</option>
                                        <option value="not_active">Not Active</option>
                                    </select>
                                </div>
                                <!-- Submit button-->
                                <button class="btn btn-primary" type="button">Add Role</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
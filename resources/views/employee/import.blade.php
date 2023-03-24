<x-app-layout title="Import Employee">
    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon.png')}}" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    @endpush

    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
        <div class="container-xl px-4">
            <div class="page-header-content pt-4">
                <div class="row align-items-center justify-content-between">
                    <div class="col-auto mt-4">
                        <h3 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file"></i></div>
                            Import Employee
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-n10">
        <x-message />
        <div class="card">
            <div class="card-header">Import Excel/CSV File Only</div>
            <div class="card-body">
                <!-- Button with lift -->
                <a class="btn btn-indigo  btn-sm lift mb-3" href="{{ route('download.example') }}">
                    <i>Download sample file</i>
                </a>
                <p class="col-12">
                    The first line in downloaded sample file should remain as it is. Please do not change the order of columns in file.
                </p>
                <p class="col-12 text-justify">
                    The correct column order is (NIK, KTP, NAME, NPWP, Date of Birth, Company Name, BPJS TK, BPJS KES, Vaccine and Entry date.)
                </p>
                <!-- Fade In Animation -->
                <div class="timeline timeline-sm">
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">First</div>
                            <div class="timeline-item-marker-indicator"><i data-feather="check"></i></div>
                        </div>
                        <div class="timeline-item-content">Date format should be (DD/MM/YYYY)</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">Second.</div>
                            <div class="timeline-item-marker-indicator"><i data-feather="check"></i></div>
                        </div>
                        <div class="timeline-item-content">Company Name must be VDNI or VDNIP</div>
                    </div>
                    <div class="timeline-item mb-3">
                        <div class="timeline-item-marker">
                            <div class="timeline-item-marker-text">Third.</div>
                            <div class="timeline-item-marker-indicator"><i data-feather="check"></i></div>
                        </div>
                        <div class="timeline-item-content">You must follow the file, otherwise you will get an error while importing the file..</div>
                    </div>
                </div>
                <form action="{{ route('import.employee') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row gx-3 mb-3">
                        <div class="mb-3 col-4">
                            <input class="form-control" name="file" type="file" id="formFile" required>
                        </div>
                        <div class="mb-3 col-3">
                            <button class="btn btn-primary" type="submit">Send file</button>
                        </div>
                    </div>

                </form>
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
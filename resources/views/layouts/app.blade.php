<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/icon.png') }}" />
    <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<!-- <body class="nav-fixed"> -->

<body>
    <nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
        <a class="navbar-brand pe-3 ps-4 ps-lg-3" href="/"><img src="{{ asset('assets/img/backgrounds/vdni-ikon.png') }}" alt="Logo VDNI" style="height: 45px; width: 90px"></a>
        <x-navbar />
    </nav>
    <div id="layoutSidenav">
        <x-sidenav />
        @foreach(getNotifPengingat() as $data)
        <div class="modal fade" id="pengingat{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Pengingat</h5>
                        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="/" method="POST" enctype="multipart/form-data" class="nav flex-column" id="stickyNav">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3 col-lg">
                                {{ $data->pesan }}
                            </div>
                            <div class="mb-3 col-lg">
                                <p class="text-muted">Tanggal Cuti : {{ date('d F Y', strtotime($data->tanggal_cuti)) }}</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary btn-sm" type="button" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        <div id="layoutSidenav_content">
            <main>
                {{ $slot }}
            </main>
            <footer class="footer-admin mt-auto footer-light">
                <x-footer />
            </footer>
        </div>
    </div>
    @stack('scripts')
    <script type="text/javascript">
        function setCookie(key, value, expiry) {
            var expires = new Date();
            expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
            document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
        }

        function googleTranslateElementInit() {
            setCookie('googtrans', '/id/ch', 1);
            new google.translate.TranslateElement({
                pageLanguage: 'id_ID'
            }, 'google_translate_element');
        }

        function triggerHtmlEvent(element, eventName) {
            var event;
            if (document.createEvent) {
                event = document.createEvent('HTMLEvents');
                event.initEvent(eventName, true, true);
                element.dispatchEvent(event);
            } else {
                event = document.createEventObject();
                event.eventType = eventName;
                element.fireEvent('on' + event.eventType, event);
            }
        }
        $(document).ready(function() {
            $(document).on("click", ".lang-select", function() {
                var theLang = $(this).attr('data-lang');
                $(".goog-te-combo").val(theLang);
                window.location = $(this).attr('href');
                window.location.reload();
            });
        });
    </script>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</body>

</html>
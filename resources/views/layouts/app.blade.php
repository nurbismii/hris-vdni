<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }} | {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png')}}" />
    @stack('styles')
</head>

<!-- <body class="nav-fixed"> -->

<body>
    <nav class="topnav navbar navbar-expand justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
        <!-- Sidenav Toggle Button-->
        <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
        <!-- Navbar Brand-->
        <!-- * * Tip * * You can use text or an image for your navbar brand.-->
        <!-- * * * * * * When using an image, we recommend the SVG format.-->
        <!-- * * * * * * Dimensions: Maximum height: 32px, maximum width: 240px-->
        <a class="navbar-brand pe-3 ps-4 ps-lg-3" href="/"><img src="{{ asset('assets/img/backgrounds/bg-auth-vdni-new.png') }}" alt="Logo VDNI" style="height: 55px; width: 120px"></a>

        <x-navbar />
        <!-- End Navbar Items -->
    </nav>
    <div id="layoutSidenav">
        <!-- Side navbar -->
        <x-sidenav />
        <!-- End Sidenav  -->
        <div id="layoutSidenav_content">
            <main>
                {{ $slot }}
            </main>
            <!-- Footer -->
            <footer class="footer-admin mt-auto footer-light">
                <x-footer />
            </footer>
            <!-- End Footer -->
        </div>
    </div>
    @stack('scripts')
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
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
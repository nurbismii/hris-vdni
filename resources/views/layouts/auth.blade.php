<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $title }} | HR CORNER </title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/backgrounds/icon.png') }}" />
    <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
    @stack('styles')
</head>

<body class="bg-auth">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                {{ $slot }}
            </main>
        </div>
        <div id="layoutAuthentication_footer">

        </div>
    </div>
    @stack('scripts')
</body>

</html>
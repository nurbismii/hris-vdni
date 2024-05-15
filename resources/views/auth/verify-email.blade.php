<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi email</title>
</head>

<body>
    <a href="{{ route('email.confirm', $data['id']) }}" class="">Konfirmasi</a>
</body>

</html>
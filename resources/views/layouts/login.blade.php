<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Celke</title>
</head>

<body class="bg-login">
    <div class="card-login">
        <div class="logo-wrapper-login">
            <a href="{{ route('login') }}">
                <img src="{{ asset('images/logo-define-500x500_v3.png')}}" alt="Logo" class="logo-login">
            </a>
        </div>
        @yield('content')
    </div>
</body>

</html>

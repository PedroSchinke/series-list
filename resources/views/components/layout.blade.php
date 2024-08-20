<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('series.index') }}">Home</a>
    
            @auth
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-link">
                    Logout
                </button>
            </form>
            @endauth

            @guest
            <a href="{{ route('login') }}">Login</a>
            @endguest
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-4">{{ $title }}</h1>

        @isset($successMessage)
            <div class="alert alert-success">
                {{ $successMessage }}
            </div>
        @endisset

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        {{ $slot }}

    </div>

    @env('local')
        <script src="http://localhost:35729/livereload.js"></script>
    @endenv

</body>
</html>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a 
                href="{{ route('series.index') }}" 
                class="text-white text-decoration-none"
            >
                Home
            </a>
    
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-link text-white text-decoration-none">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a 
                    href="{{ route('login') }}" 
                    class="text-white text-decoration-none"
                >
                    Login
                </a>
            @endguest
        </div>
    </nav>

    <div class="container mb-5 mt-3">
        
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
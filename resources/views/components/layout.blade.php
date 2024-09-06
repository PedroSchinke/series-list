<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>

    {{-- Styles --}}
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/styles.css')}}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- Scripts --}}
    <script defer src="{{ mix('js/app.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a 
                href="{{ route('series.index') }}" 
                class="btn btn-link text-white text-decoration-none"
                style="font-family: 'Pacifico', cursive; font-size: 1.8rem;"
            >
                SeriesFlix
            </a>
    
            @auth
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button 
                        class="d-flex align-items-center justify-content-center btn btn-link text-white fw-bold text-decoration-none p-0" 
                        style="font-family: 'Nunito', sans-serif"
                        title="Log out"
                    >
                        <i class='bx bx-log-out' style="font-size: 1.3rem"></i>
                    </button>
                </form>
            @endauth

            @guest
                <a 
                    href="{{ route('login') }}" 
                    class="d-flex align-items-center justify-content-center btn btn-link text-white fw-bold text-decoration-none"
                    title="Log in"
                >
                    <i class='bx bx-log-in' style="font-size: 1.3rem"></i>
                </a>
            @endguest
        </div>
    </nav>

    <div class="bg-secondary p-5 pt-4" style="min-height: calc(100% - 72.35px)">
        
        @isset($successMessage)
            <div class="alert alert-success">
                {{ $successMessage }}
            </div>
        @endisset

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 px-0">
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

    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script defer src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function(){
            $(".owl-carousel").owlCarousel({
                items: 5,
                nav: true,
                margin: 3,
                navSpeed: 1000,
                navText: ['<i class="bx bx-chevron-left text-light"></i>', '<i class="bx bx-chevron-right text-light"></i>']
            });
        });
    </script>
</body>
</html>
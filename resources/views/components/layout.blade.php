<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <script src="{{ mix('js/app.js') }}"></script>
</head>
<body>
    <div class="container">
        <h1>{{ $title }}</h1>

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
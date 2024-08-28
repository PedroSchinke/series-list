<x-layout title="Series" :successMessage="$successMessage">

    <div class="d-flex align-items-center justify-content-between px-2">
        <h1>Series</h1>

        @auth
        <a href="{{ route('series.create') }}" class="btn btn-dark">Add</a>
        @endauth
    </div>

    <ul class="list-group">
        @foreach ($seriesArray as $series)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2 align-items-center">
                    <img 
                        src="{{ asset($series->cover) }}" 
                        alt="{{ $series->name }} cover"
                        class="img-thumbnail"
                        style="width: 100px"
                    >
    
                    <a href="{{ route('seasons.index', $series->id) }}">
                        {{ $series->name }}
                    </a>
                </div>

                @auth
                <div class="d-flex gap-2">
                    <a 
                        href="{{ route('series.edit', $series->id) }}"
                        class="btn btn-primary btn-sm"
                    >
                        Edit
                    </a>
        
                    <form action="{{ route('series.destroy', $series->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">
                            X
                        </button>
                    </form>
                </div>
                @endauth

            </li>
        @endforeach
    </ul>

    <div class="d-flex justify-content-center align-items-center gap-3 pt-3 pb-3" style="width: 100%">
        <a 
            href="{{ $previousPageUrl }}" 
            class="btn btn-primary btn-sm @if (!isset($previousPageUrl)) disabled @endif"
        >
            Previous
        </a>

        <div class="d-flex gap-2">
            @for ($i = 1; $i <= $lastPage; $i++)
                <a 
                    href="http://127.0.0.1:8000/series?page={{ $i }}"
                    class="text-decoration-none"
                    style="@if ($i !== $currentPage) color: #96B1B8; @endif"
                >
                    {{ $i }}
                </a>
            @endfor
        </div>

        <a 
            href="{{ $nextPageUrl }}" 
            class="btn btn-primary btn-sm @if (!isset($nextPageUrl)) disabled @endif"
        >
            Next
        </a>
    </div>

</x-layout>
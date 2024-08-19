<x-layout title="Series">
    @auth
    <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Add</a>
    @endauth

    @isset($successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endisset

    <ul class="list-group">
        @foreach ($seriesArray as $series)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('seasons.index', $series->id) }}">
                    {{ $series->name }}
                </a>

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
</x-layout>
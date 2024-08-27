<x-layout title="Series" :successMessage="$successMessage">
    @auth
    <a href="{{ route('series.create') }}" class="btn btn-dark mb-2">Add</a>
    @endauth

    <ul class="list-group">
        @foreach ($seriesArray as $series)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div class="d-flex gap-2 align-items-center">
                    <img 
                        src="{{ asset('storage/' . $series->cover) }}" 
                        alt="Series cover"
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

    <div class="d-flex justify-content-center gap-4 pt-3 pb-3" style="width: 100%">
        <a href="" class="btn btn-primary btn-sm">Previous</a>
        <a href="" class="btn btn-primary btn-sm">Next</a>
    </div>
</x-layout>
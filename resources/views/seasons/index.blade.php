<x-layout title="Seasons of {!! $series->name !!}" :successMessage="$successMessage">

    <img 
        src="{{ asset('storage/' . $series->cover) }}" 
        alt="Series cover"
        class="img-fluid"
        style="height: 250px"
    >

    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('episodes.index', $season->id) }}">
                    Season {{ $season->number }}
                </a>

                <div class="badge bg-secondary">
                    {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </div>

            </li>
        @endforeach
    </ul>

</x-layout> 
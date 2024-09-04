<x-layout title="Seasons of {!! $series->name !!}" :successMessage="$successMessage">
    <h1 class="text-light fw-bold" style="font-family: 'Nunito', sans-serif">Seasons of {{$series->name}}</h1>

    <img 
        src="{{ asset($series->cover) }}" 
        alt="Series cover"
        class="img-fluid"
        style="height: 250px"
    >

    <ul class="d-flex flex-column gap-2 p-0 mt-3">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('episodes.index', $season->id) }}" class="text-light text-decoration-none">
                    Season {{ $season->number }}
                </a>

                <div class="badge bg-secondary text-primary">
                    {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </div>

            </li>
        @endforeach
    </ul>

</x-layout> 
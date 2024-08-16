<x-layout title="Seasons of {!! $series->name !!}">

    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('episodes.index', $season->id) }}">
                    Season {{ $season->number }}
                </a>

                <div class="badge bg-secondary">
                    {{ $season->episodes->count() }}
                </div>

            </li>
        @endforeach
    </ul>
    
</x-layout> 
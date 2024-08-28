<x-layout title="Episodes of Season {!! $season->number !!} of {!! $series->name !!}">
    <h1>Episodes of season {{ $season->number }} of {{ $series->name }}</h1>

    <form action="{{ route('episodes.update', ['season' => $season->id]) }}" method="POST">
        @csrf
        {{-- @method('PUT') --}}
        <ul class="list-group">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episode {{ $episode->number }}
    
                    <input 
                        type="checkbox" 
                        name="episodes[]" 
                        value="{{ $episode->id }}"
                        @if ($episode->watched) checked @endif
                    />
                </li>
            @endforeach
        </ul>

        <button class="btn btn-primary mt-2 mb-2">Save</button>
    </form>

</x-layout> 
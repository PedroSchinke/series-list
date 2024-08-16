<x-layout title="Episodes of Season {!! $season->number !!}">

    <form action="{{ route('episodes.update', $episode->id) }}" method="POST">
        @csrf
        <ul class="list-group">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episode {{ $episode->number }}
    
                    <input type="checkbox" name="episodes[]" value="{{ $episode->id }}">
                </li>
            @endforeach
        </ul>

        <button class="btn btn-primary mt-2 mb-2">Save</button>
    </form>

</x-layout> 
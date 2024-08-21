<x-layout title="Edit series '{!! $series->name !!}'">
    <form action="{{ route('series.update', $series->id) }}" method="POST">
        @csrf
        @method('PUT')
    
        <div class="row mb-3">
            <div class="col-6">
                <label for="name" class="form-label">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control"
                    value="{{ $series->name }}"
                    autofocus
                >
            </div>

            <div class="col-">
                <label for="seasonsQty" class="form-label">Number of seasons:</label>
                <input 
                    type="text" 
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control"
                    value="{{ $series->seasons->count() }}"
                >
            </div>

            <div class="col-3">
                <label for="episodesPerSeason" class="form-label">Episodes per season:</label>
                <input 
                    type="text" 
                    id="episodesPerSeason" 
                    name="episodesPerSeason" 
                    class="form-control"
                    value="{{ $series->seasons->flatMap->episodes->count() / $series->seasons->count() }}"
                >
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</x-layout>

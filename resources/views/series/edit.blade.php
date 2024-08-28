<x-layout title="Edit series '{!! $series->name !!}'">
    <h1>Edit {{ $series->name }}</h1>
    
    <form 
        action="{{ route('series.update', $series->id) }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')
    
        <div class="d-flex flex-column mb-3 gap-2">
            <div class="col-6">
                <label for="name" class="form-label mb-1">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control"
                    value="{{ $series->name }}"
                    autofocus
                >
            </div>

            <div class="column col-1">
                <label for="seasonsQty" class="form-label mb-1" style="width: 200px">Number of seasons:</label>
                <input 
                    type="text" 
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control"
                    value="{{ $series->seasons->count() }}"
                >
            </div>

            <div class="col-1">
                <label for="episodesPerSeason" class="form-label mb-1" style="width: 200px">Episodes per season:</label>
                <input 
                    type="text" 
                    id="episodesPerSeason" 
                    name="episodesPerSeason" 
                    class="form-control"
                    value="{{ $series->episodes->count() / $series->seasons->count() }}"
                >
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label for="cover" class="form-label mb-1">Cover</label>
                    <input 
                        type="file" 
                        id="cover" 
                        name="cover" 
                        class="form-control"
                        accept="image/gif, image/jpeg, image/png"
                    >
                </div>
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</x-layout>

<x-layout title="Edit series '{!! $series->name !!}'">
    <h1 class="text-light mb-3">Edit {{ $series->name }}</h1>
    
    <form 
        action="{{ route('series.update', $series->id) }}" 
        method="POST" 
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')
    
        <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-center gap-3">
                <label for="name" class="form-label text-light">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control w-50 bg-dark dark-input"
                    value="{{ $series->name }}"
                    autofocus
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="seasonsQty" class="form-label text-light">Number of seasons</label>
                <input 
                    type="number" 
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control bg-dark dark-input"
                    style="width: 60px"
                    value="{{ $series->seasonsQty }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="episodesPerSeason" class="form-label text-light">Episodes per season</label>
                <input 
                    type="number" 
                    id="episodesPerSeason" 
                    name="episodesPerSeason" 
                    class="form-control bg-dark dark-input"
                    style="width: 60px"
                    value="{{ $series->episodesPerSeason }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="cover" class="form-label text-light">Cover</label>
                <input 
                    type="file" 
                    id="cover" 
                    name="cover" 
                    class="form-control w-75 bg-dark dark-input"
                    accept="image/gif, image/jpeg, image/png"
                >
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>
</x-layout>

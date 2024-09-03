<x-layout title="New series">
    <h1 class="mb-3">New series</h1>

    <form 
        action="{{ route('series.store') }}" 
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
    
        <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-center gap-3">
                <label for="name" class="form-label">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control w-50"
                    value="{{ old('name') }}"
                    autofocus
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="seasonsQty" class="form-label">Number of seasons</label>
                <input 
                    type="number" 
                    min="1"
                    max="30"
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control"
                    style="width: 60px"
                    value="{{ old('seasonsQty') }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="episodesPerSeason" class="form-label">Episodes per season</label>
                <input 
                    type="number" 
                    min="1"
                    max="30"
                    id="episodesPerSeason" 
                    name="episodesPerSeason" 
                    class="form-control"
                    style="width: 60px"
                    value="{{ old('episodesPerSeason') }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="cover" class="form-label">Cover</label>
                <input 
                    type="file" 
                    id="cover" 
                    name="cover" 
                    class="form-control w-75"
                    accept="image/gif, image/jpeg, image/png"
                >
            </div>

        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Add</button>
    </form>
</x-layout>

<x-layout title="New series">
    <h1>New series</h1>

    <form 
        action="{{ route('series.store') }}" 
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
    
        <div class="row mb-3">
            <div class="col-6">
                <label for="name" class="form-label">Name:</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control"
                    value="{{ old('name') }}"
                    autofocus
                >
            </div>

            <div class="col-3">
                <label for="seasonsQty" class="form-label">Number of seasons:</label>
                <input 
                    type="text" 
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control"
                    value="{{ old('seasonsQty') }}"
                >
            </div>

            <div class="col-3">
                <label for="episodesPerSeason" class="form-label">Episodes per season:</label>
                <input 
                    type="text" 
                    id="episodesPerSeason" 
                    name="episodesPerSeason" 
                    class="form-control"
                    value="{{ old('episodesPerSeason') }}"
                >
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="cover" class="form-label">Cover</label>
                <input 
                    type="file" 
                    id="cover" 
                    name="cover" 
                    class="form-control"
                    accept="image/gif, image/jpeg, image/png"
                >
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</x-layout>

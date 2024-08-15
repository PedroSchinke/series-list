<x-layout title="New series">
    <form action="{{ route('series.store') }}" method="POST">
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
    
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</x-layout>

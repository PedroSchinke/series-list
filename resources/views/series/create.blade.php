<x-layout title="New series">
    <h1 class="text-light mb-3">New series</h1>

    <form 
        action="{{ route('series.store') }}" 
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
    
        <div class="d-flex flex-column gap-3">
            <div class="d-flex align-items-center gap-3">
                <label for="name" class="form-label text-light mb-0">Name</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-control w-50 bg-dark dark-input"
                    value="{{ old('name') }}"
                    autofocus
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="synopsis" class="form-label text-light mb-0">Synopsis</label>
                <textarea 
                    type="text" 
                    id="synopsis" 
                    name="synopsis" 
                    class="form-control w-75 bg-dark dark-input"
                    style="resize: none; font-size: 0.8rem;"
                    value="{{ old('synopsis') }}"
                ></textarea>
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="seasons_qty" class="form-label text-light mb-0">Number of seasons</label>
                <input 
                    type="number" 
                    min="1"
                    max="30"
                    id="seasons_qty" 
                    name="seasons_qty" 
                    class="form-control bg-dark dark-input"
                    style="width: 60px"
                    value="{{ old('seasons_qty') }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="episodes_per_season" class="form-label text-light mb-0">Episodes per season</label>
                <input 
                    type="number" 
                    min="1"
                    max="30"
                    id="episodes_per_season" 
                    name="episodes_per_season" 
                    class="form-control bg-dark dark-input"
                    style="width: 60px"
                    value="{{ old('episodes_per_season') }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="cover" class="form-label text-light mb-0">Cover</label>
                <input 
                    type="file" 
                    id="cover" 
                    name="cover" 
                    class="form-control w-75 bg-dark dark-input"
                    accept="image/gif, image/jpeg, image/png"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="cover" class="form-label text-light mb-0">Categories (max. 4)</label>
                <select 
                    id="categories"
                    class="bg-dark text-light rounded-2 border-0 dark-input"
                    style="cursor: pointer"
                >
                    <option id="default-option" class="bg-dark text-light fst-italic rounded">Select</option>
                    @forEach($categories as $category)
                        <option 
                            value="{{ $category->id }}"
                            class="bg-dark text-light rounded"
                            style="cursor: pointer"
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <div id="categories-selected-container" class="d-flex align-items-center gap-2"></div>
                <input type="hidden" name="categories" id="selected-categories">
            </div>

        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>

    <script>
        var categories = [];
    </script>

    <script src="{{ mix('js/categories-select.js') }}"></script>
</x-layout>

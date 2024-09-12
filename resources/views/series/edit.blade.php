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
                <label for="name" class="form-label text-light mb-0">Name</label>
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
                <label for="seasonsQty" class="form-label text-light mb-0">Number of seasons</label>
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
                <label for="episodesPerSeason" class="form-label text-light mb-0">Episodes per season</label>
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
                <label for="cover" class="form-label text-light mb-0">Categories</label>
                <select 
                    name="categories" 
                    id="categories"
                    class="bg-dark text-light rounded-2 border-0 dark-input"
                    style="cursor: pointer"
                >
                    <option id="default-option" class="bg-dark text-light fst-italic rounded">Select</option>
                    @forEach($categories as $category)
                        <option 
                            value="{{ $category->id }}"
                            class="bg-dark text-light rounded"
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <div id="categories-selected-container" class="d-flex align-items-center gap-2">
                    @foreach($series->categories as $category)
                        <div class="d-flex align-items-center gap-1">
                            <span>{{ $category->name }}</span>
                            <button type="button" data-value="${value}" class="btn btn-sm btn-danger">
                                <i class='bx bx-x'></i>
                            </button>
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="selected_categories" id="selected-categories">
            </div>
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Save</button>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categorySelect = document.getElementById('categories');
            const categoriesSelectedContainer = document.getElementById('categories-selected-container');
            const selectedCategoriesInput = document.getElementById('selected-categories');

            let selectedCategories = [];

            categorySelect.addEventListener('change', function() {
                const selectedValue = categorySelect.value;
                if (selectedValue && !selectedCategories.includes(selectedValue)) {
                    selectedCategories.push(selectedValue);
                    console.log(selectedCategories);
                    updateSelectedCategories();
                }
            });

            categoriesSelectedContainer.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON') {
                    const valueToRemove = e.target.dataset.value;
                    selectedCategories = selectedCategories.filter(value => value !== valueToRemove);
                    updateSelectedCategories();
                }
            });

            function updateSelectedCategories() {
                categoriesSelectedContainer.innerHTML = selectedCategories.map(value => `
                    <div class="d-flex align-items-center gap-1">
                        <span>${categorySelect.querySelector(`option[value="${value}"]`).text}</span>
                        <button type="button" data-value="${value}" class="btn btn-sm btn-danger">
                            <i class='bx bx-x'></i>
                        </button>
                    </div>
                `).join('');
                
                selectedCategoriesInput.value = selectedCategories.join(',');
            }
        });
    </script>
</x-layout>
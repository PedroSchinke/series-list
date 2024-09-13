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
                <label for="seasonsQty" class="form-label text-light mb-0">Number of seasons</label>
                <input 
                    type="number" 
                    min="1"
                    max="30"
                    id="seasonsQty" 
                    name="seasonsQty" 
                    class="form-control bg-dark dark-input"
                    style="width: 60px"
                    value="{{ old('seasonsQty') }}"
                >
            </div>

            <div class="d-flex align-items-center gap-3">
                <label for="episodesPerSeason" class="form-label text-light mb-0">Episodes per season</label>
                <input 
                    type="number" 
                    min="1"
                    max="30"
                    id="episodesPerSeason" 
                    name="episodesPerSeason" 
                    class="form-control bg-dark dark-input"
                    style="width: 60px"
                    value="{{ old('episodesPerSeason') }}"
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
                            style="cursor: pointer"
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <div id="categories-selected-container" class="d-flex align-items-center gap-2"></div>
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
                const selectedValue = parseInt(categorySelect.value);
                if (selectedValue && !selectedCategories.includes(selectedValue) && selectedCategories.length < 4) {
                    selectedCategories.push(selectedValue);
                    updateSelectedCategories();
                }
                categorySelect.value = categorySelect.querySelector(`option[id="default-option"]`).textContent;
            });

            categoriesSelectedContainer.addEventListener('click', function(e) {
                const button = e.target.closest('button');
                if (button) {
                    const valueToRemove = parseInt(button.dataset.value);
                    selectedCategories = selectedCategories.filter(value => value !== valueToRemove);
                    console.log(selectedCategories);
                    updateSelectedCategories();
                }
            });

            function updateSelectedCategories() {
                categoriesSelectedContainer.innerHTML = selectedCategories.map(value => {
                    const optionText = categorySelect.querySelector(`option[value="${value}"]`).textContent;

                    return `
                        <div class="d-flex align-items-center">
                            <span class="text-gray-500">${optionText}</span>
                            <button 
                                type="button" data-value="${value}"
                                class="btn btn-sm bg-transparent d-flex align-items-center p-0 mt-1" 
                                style="width: fit-content; height: fit-content;"
                            >
                                <i class='bx bx-x'></i>
                            </button>
                        </div>
                    `;
                }).join('');
                
                selectedCategoriesInput.value = selectedCategories;
            }
        });
    </script>
</x-layout>

document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('categories');
    const categoriesSelectedContainer = document.getElementById('categories-selected-container');
    const selectedCategoriesInput = document.getElementById('selected-categories');

    let selectedCategories = categories;

    updateSelectedCategories();

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
                        class="btn btn-sm bg-transparent d-flex align-items-center p-0" 
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
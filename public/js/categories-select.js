/******/ (() => { // webpackBootstrap
/*!*******************************************!*\
  !*** ./resources/js/categories-select.js ***!
  \*******************************************/
document.addEventListener('DOMContentLoaded', function () {
  var categorySelect = document.getElementById('categories');
  var categoriesSelectedContainer = document.getElementById('categories-selected-container');
  var selectedCategoriesInput = document.getElementById('selected-categories');
  var selectedCategories = categories;
  updateSelectedCategories();
  categorySelect.addEventListener('change', function () {
    var selectedValue = parseInt(categorySelect.value);
    if (selectedValue && !selectedCategories.includes(selectedValue) && selectedCategories.length < 4) {
      selectedCategories.push(selectedValue);
      updateSelectedCategories();
    }
    categorySelect.value = categorySelect.querySelector("option[id=\"default-option\"]").textContent;
  });
  categoriesSelectedContainer.addEventListener('click', function (e) {
    var button = e.target.closest('button');
    if (button) {
      var valueToRemove = parseInt(button.dataset.value);
      selectedCategories = selectedCategories.filter(function (value) {
        return value !== valueToRemove;
      });
      updateSelectedCategories();
    }
  });
  function updateSelectedCategories() {
    categoriesSelectedContainer.innerHTML = selectedCategories.map(function (value) {
      var optionText = categorySelect.querySelector("option[value=\"".concat(value, "\"]")).textContent;
      return "\n                <div class=\"d-flex align-items-center\">\n                    <span class=\"text-gray-500\">".concat(optionText, "</span>\n                    <button \n                        type=\"button\" data-value=\"").concat(value, "\"\n                        class=\"btn btn-sm bg-transparent d-flex align-items-center p-0\" \n                        style=\"width: fit-content; height: fit-content;\"\n                    >\n                        <i class='bx bx-x'></i>\n                    </button>\n                </div>\n            ");
    }).join('');
    selectedCategoriesInput.value = selectedCategories;
  }
});
/******/ })()
;
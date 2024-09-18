/******/ (() => { // webpackBootstrap
/*!*************************************************!*\
  !*** ./resources/js/favorites-filter-button.js ***!
  \*************************************************/
var favoriteToggle = document.getElementById('favorite-toggle');
var favoritesInput = document.getElementById('favorites-selected');
favoriteToggle.addEventListener('click', function () {
  if (favoritesInput.value == 1) {
    this.classList.remove('selected');
    favoritesInput.value = 0;
  } else {
    this.classList.add('selected');
    favoritesInput.value = 1;
  }
});
/******/ })()
;
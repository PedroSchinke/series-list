/******/ (() => { // webpackBootstrap
/*!*************************************************!*\
  !*** ./resources/js/add-to-favorites-button.js ***!
  \*************************************************/
document.querySelectorAll('.favorite-button').forEach(function (button) {
  button.addEventListener('click', function (e) {
    var _this = this;
    e.preventDefault();
    var seriesId = this.getAttribute('data-series-id');
    fetch("/user/favorite-series/".concat(seriesId), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
      },
      body: JSON.stringify({
        series_id: seriesId
      })
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      var icon = _this.querySelector('.icon-favorite');
      if (data.favorite) {
        icon.classList.remove('bx-star', 'text-light', 'opacity-75');
        icon.classList.add('bxs-star', 'text-primary');
        _this.title = 'Remove from favorites';
      } else {
        icon.classList.remove('bxs-star', 'text-primary');
        icon.classList.add('bx-star', 'text-light', 'opacity-75');
        _this.title = 'Add to favorites';
      }
    })["catch"](function (error) {
      return console.error('Error:', error);
    });
  });
});
/******/ })()
;
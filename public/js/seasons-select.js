/******/ (() => { // webpackBootstrap
/*!****************************************!*\
  !*** ./resources/js/seasons-select.js ***!
  \****************************************/
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('season').addEventListener('change', function () {
    var seasonId = this.value;
    fetch("/seasons/".concat(seasonId, "/episodes"), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (response) {
      return response.json();
    }).then(function (episodes) {
      $('.owl-carousel').trigger('destroy.owl.carousel'); // Destroys current carousel

      var carouselContainer = document.querySelector('.owl-carousel');
      carouselContainer.innerHTML = '';
      episodes.forEach(function (episode) {
        var episodeItem = "\n                    <li class=\"list-item d-flex align-items-center gap-2\" style=\"margin: 2px\">\n                        <div class=\"bg-black rounded episode-card\">\n                            <img src=\"".concat(series.cover, "\" alt=\"").concat(series.name, " cover\" class=\"rounded-top\">\n                            <div class=\"d-flex align-items-center p-1\">\n                                <p class=\"text-gray-300 m-0\">Episode ").concat(episode.number, " ").concat(episode.id, "</p>\n                            </div>\n                        </div>\n                    </li>\n                ");
        carouselContainer.innerHTML += episodeItem;
      });

      // Creates new carousel
      $(".owl-carousel").owlCarousel({
        items: 5,
        nav: true,
        margin: 3,
        navSpeed: 1000,
        navText: ['<i class="bx bx-chevron-left text-light"></i>', '<i class="bx bx-chevron-right text-light"></i>']
      });
    })["catch"](function (error) {
      return console.log('Error:', error);
    });
  });
});
/******/ })()
;
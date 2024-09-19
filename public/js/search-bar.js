/******/ (() => { // webpackBootstrap
/*!************************************!*\
  !*** ./resources/js/search-bar.js ***!
  \************************************/
var typingTimer;
document.getElementById('seriesSearch').addEventListener('input', function () {
  clearTimeout(typingTimer);
  var seriesName = this.value;
  var favoritesSelected = document.getElementById('favorites-selected').value;
  var selectedCategories = document.getElementById('selected-categories').value;
  typingTimer = setTimeout(function () {
    fetch("/series?name=".concat(seriesName, "&favorites=").concat(favoritesSelected, "&categories=").concat(selectedCategories), {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (response) {
      return response.json();
    }).then(function (series) {
      var csrfToken = document.querySelector('[name="csrf-token"]').content;
      var seriesNavBar = document.getElementById('series-nav-bar');
      var seriesList = document.getElementById('series-list');
      seriesList.innerHTML = '';
      if (series['data'].length > 0) {
        series['data'].forEach(function (series) {
          var categories = series.categories.map(function (category) {
            return "\n                            <span class=\"bg-dark rounded\" style=\"font-size: 0.5rem; padding: 1px 4px;\">".concat(category.name, "</span>\n                        ");
          }).join('');
          var titleIsFavorite = series.isFavorite ? 'Remove from favorites' : 'Add to favorites';
          var iconIsFavorite = series.isFavorite ? 'bxs-star text-primary' : 'bx-star text-light opacity-75';
          var seriesItem = "\n                        <li \n                            class=\"d-flex justify-content-between align-items-center p-0 series\" \n                            style=\"height: 60px; box-shadow: 0px 0px 3px 1px #252525; border-radius: 10px; padding: 7px 12px; cursor: pointer;\"\n                        >\n                            <a href=\"/series/".concat(series.id, "\" class=\"text-decoration-none text-light w-100 series-card\">\n                                <div class=\"d-flex gap-2 align-items-center\">\n                                    <img \n                                        src=\"").concat(series.cover, "\" \n                                        alt=\"").concat(series.name, " cover\"\n                                        style=\"width: 100px; height: 60px; object-fit: cover; border-top-left-radius: 10px; border-bottom-left-radius: 10px;\"\n                                    >\n                                    <button\n                                        data-series-id=\"").concat(series.id, "\" \n                                        class=\"bg-transparent favorite-button\"\n                                        style=\"width: fit-content; height: fit-content;\"\n                                        title=\"").concat(titleIsFavorite, "\"\n                                    >\n                                        <i class='bx ").concat(iconIsFavorite, " icon-favorite'></i>\n                                    </button>\n                                    <div class=\"d-flex flex-column\">\n                                        ").concat(series.name, "\n                                        <div class=\"d-flex gap-1\">\n                                            ").concat(categories, "\n                                        </div>\n                                    </div>\n                                </div>\n                            </a>\n\n                            <div class=\"d-none gap-2 align-items-center h-100 series-buttons\" style=\"display: none;\">\n                                <a \n                                    href=\"/series/").concat(series.id, "/edit\"\n                                    class=\"btn btn-sm d-flex align-items-center\"\n                                    style=\"width: 1.2rem; background-color: transparent; padding: 0;\"\n                                >\n                                    <i class='bx bxs-pencil bx-xs series-icon-button' title=\"Edit\"></i>\n                                </a>\n                    \n                                <form action=\"/series/").concat(series.id, "\" method=\"POST\" style=\"width: fit-content; height: fit-content;\">\n                                    <input type=\"hidden\" name=\"_token\" value=\"").concat(csrfToken, "\">\n                                    <input type=\"hidden\" name=\"_method\" value=\"DELETE\">\n                                    <button \n                                        class=\"btn btn-sm d-flex justify-content-center align-items-center p-0\" \n                                        style=\"width: 1.2rem; height: 1.2rem; background-color: transparent;\"\n                                    >\n                                        <i class='bx bxs-trash-alt bx-xs series-icon-button' title=\"Delete\"></i>\n                                    </button>\n                                </form>\n\n                                <a \n                                    href=\"/series/").concat(series.id, "\"\n                                    class=\"d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none\"  \n                                    style=\"width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;\"\n                                >\n                                    <i class='bx bxs-chevron-right text-secondary' ></i>\n                                </a>\n                            </div>\n                        </li>\n                    ");
          seriesList.innerHTML += seriesItem;
        });
        var navPages = series.links.map(function (page, index, arr) {
          var isPrevPageDisabled = series.prev_page_url ? null : 'disabled';
          var isNextPageDisabled = series.next_page_url ? null : 'disabled';
          if (index === 0) {
            return "\n                            <a \n                                href=\"".concat(series.prev_page_url, "\" \n                                class=\"btn d-flex align-items-center justify-content-center text-decoration-none ").concat(isPrevPageDisabled, "\"\n                                style=\"height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none; margin-top: 2px;\"\n                            >\n                                <i class='bx bxs-left-arrow text-primary' title=\"Previous page\"></i>\n                            </a>\n                        ");
          } else if (index === arr.length - 1) {
            return "\n                            <a \n                                href=\"".concat(series.next_page_url, "\" \n                                class=\"btn d-flex align-items-center justify-content-center text-decoration-none ").concat(isNextPageDisabled, "\"\n                                style=\"height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none; margin-top: 2px;\"\n                            >\n                                <i class='bx bxs-right-arrow text-primary' title=\"Next page\"></i>\n                            </a>\n                        ");
          }
          var pageStyle = index !== series.current_page ? 'opacity: 50%;' : null;
          return "\n                        <a \n                            href=\"".concat(page.url, "\"\n                            class=\"text-decoration-none text-primary\"\n                            style=\"").concat(pageStyle, "\"\n                        >\n                            ").concat(page.label, "\n                        </a>\n                    ");
        }).join('');
        seriesNavBar.innerHTML = "\n                    <section class=\"d-flex align-items-center gap-2\">\n                        ".concat(navPages, "\n                    </section>\n                ");
      } else {
        seriesNavBar.innerHTML = '';
        var noResultsMessage = "\n                    <div class=\"d-flex justify-content-center mt-4\">\n                        <p class=\"text-light\">No series with these filters were found</p>\n                    </div>\n                ";
        seriesList.innerHTML = noResultsMessage;
      }
    })["catch"](function (error) {
      return console.log('Error:', error);
    });
  }, 2000);
});
/******/ })()
;
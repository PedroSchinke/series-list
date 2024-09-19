let typingTimer;

document.getElementById('seriesSearch').addEventListener('input', function() {
    clearTimeout(typingTimer);

    const seriesName = this.value;

    typingTimer = setTimeout(function() {
        fetch(`/series?name=${seriesName}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(series => {
            const csrfToken = document.querySelector('[name="csrf-token"]').content;

            const seriesNavBar = document.getElementById('series-nav-bar');

            const seriesList = document.getElementById('series-list');
            seriesList.innerHTML = '';

            if (series['data'].length > 0) {
                series['data'].forEach(series => {
                    const categories = series.categories.map(category => {
                        return `
                            <span class="bg-dark rounded" style="font-size: 0.5rem; padding: 1px 4px;">${category.name}</span>
                        `;
                    }).join('');
                    const titleIsFavorite = series.isFavorite ? 'Remove from favorites' : 'Add to favorites';
                    const iconIsFavorite = series.isFavorite ? 'bxs-star text-primary' : 'bx-star text-light opacity-75';
                    const seriesItem = `
                        <li 
                            class="d-flex justify-content-between align-items-center p-0 series" 
                            style="height: 60px; box-shadow: 0px 0px 3px 1px #252525; border-radius: 10px; padding: 7px 12px; cursor: pointer;"
                        >
                            <a href="/series/${series.id}" class="text-decoration-none text-light w-100 series-card">
                                <div class="d-flex gap-2 align-items-center">
                                    <img 
                                        src="${series.cover}" 
                                        alt="${series.name} cover"
                                        style="width: 100px; height: 60px; object-fit: cover; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"
                                    >
                                    <button
                                        data-series-id="${series.id}" 
                                        class="bg-transparent favorite-button"
                                        style="width: fit-content; height: fit-content;"
                                        title="${titleIsFavorite}"
                                    >
                                        <i class='bx ${iconIsFavorite} icon-favorite'></i>
                                    </button>
                                    <div class="d-flex flex-column">
                                        ${series.name}
                                        <div class="d-flex gap-1">
                                            ${categories}
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <div class="d-none gap-2 align-items-center h-100 series-buttons" style="display: none;">
                                <a 
                                    href="/series/${series.id}/edit"
                                    class="btn btn-sm d-flex align-items-center"
                                    style="width: 1.2rem; background-color: transparent; padding: 0;"
                                >
                                    <i class='bx bxs-pencil bx-xs series-icon-button' title="Edit"></i>
                                </a>
                    
                                <form action="/series/${series.id}" method="POST" style="width: fit-content; height: fit-content;">
                                    <input type="hidden" name="_token" value="${csrfToken}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button 
                                        class="btn btn-sm d-flex justify-content-center align-items-center p-0" 
                                        style="width: 1.2rem; height: 1.2rem; background-color: transparent;"
                                    >
                                        <i class='bx bxs-trash-alt bx-xs series-icon-button' title="Delete"></i>
                                    </button>
                                </form>

                                <a 
                                    href="/series/${series.id}"
                                    class="d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none"  
                                    style="width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
                                >
                                    <i class='bx bxs-chevron-right text-secondary' ></i>
                                </a>
                            </div>
                        </li>
                    `;
                    seriesList.innerHTML += seriesItem;
                })
                
                const navPages = series.links.map((page, index, arr) => {
                    const isPrevPageDisabled = series.prev_page_url ? null : 'disabled';
                    const isNextPageDisabled = series.next_page_url ? null : 'disabled';
                    if (index === 0) {
                        return `
                            <a 
                                href="${series.prev_page_url}" 
                                class="btn d-flex align-items-center justify-content-center text-decoration-none ${isPrevPageDisabled}"
                                style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none; margin-top: 2px;"
                            >
                                <i class='bx bxs-left-arrow text-primary' title="Previous page"></i>
                            </a>
                        `;
                    } else if (index === arr.length - 1) {
                        return `
                            <a 
                                href="${series.next_page_url}" 
                                class="btn d-flex align-items-center justify-content-center text-decoration-none ${isNextPageDisabled}"
                                style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none; margin-top: 2px;"
                            >
                                <i class='bx bxs-right-arrow text-primary' title="Next page"></i>
                            </a>
                        `;
                    }
                    const pageStyle = index !== series.current_page ? 'opacity: 50%;' : null;
                    return `
                        <a 
                            href="${page.url}"
                            class="text-decoration-none text-primary"
                            style="${pageStyle}"
                        >
                            ${page.label}
                        </a>
                    `;
                }).join('');
                
                seriesNavBar.innerHTML = `
                    <section class="d-flex align-items-center gap-2">
                        ${navPages}
                    </section>
                `;
            } else {
                seriesNavBar.innerHTML = '';

                const noResultsMessage = `
                    <div class="d-flex justify-content-center mt-4">
                        <p class="text-light">No series with these filters were found</p>
                    </div>
                `;
                seriesList.innerHTML = noResultsMessage;
            }
        })
        .catch(error => console.log('Error:', error));
    }, 2000)
});
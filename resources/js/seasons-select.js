document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('season').addEventListener('change', function() {
        let seasonId = this.value;
        
        fetch(`/seasons/${seasonId}/episodes`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(episodes => {
            $('.owl-carousel').trigger('destroy.owl.carousel'); // Destroys current carousel
    
            let carouselContainer = document.querySelector('.owl-carousel');
            carouselContainer.innerHTML = '';
            
            episodes.forEach(episode => {
                let episodeItem = `
                    <li class="list-item d-flex align-items-center gap-2" style="margin: 2px">
                        <div class="bg-black rounded episode-card">
                            <img src="${series.cover}" alt="${series.name} cover" class="rounded-top">
                            <div class="d-flex align-items-center p-1">
                                <p class="text-gray-300 m-0">Episode ${episode.number} ${episode.id}</p>
                            </div>
                        </div>
                    </li>
                `;
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
        })
        .catch(error => console.log('Error:', error));
    });
});
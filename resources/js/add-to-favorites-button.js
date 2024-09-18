document.querySelectorAll('.favorite-button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();

        let seriesId = this.getAttribute('data-series-id');

        fetch(`/user/favorite-series/${seriesId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                series_id: seriesId
            })
        })
        .then(response => response.json())
        .then(data => {
            let icon = this.querySelector('.icon-favorite');
            if (data.favorite) {
                icon.classList.remove('bx-star', 'text-light', 'opacity-75');
                icon.classList.add('bxs-star', 'text-primary');
                this.title = 'Remove from favorites';
            } else {
                icon.classList.remove('bxs-star', 'text-primary');
                icon.classList.add('bx-star', 'text-light', 'opacity-75');
                this.title = 'Add to favorites';
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
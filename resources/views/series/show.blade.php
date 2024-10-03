<x-layout title="SeriesFlix - {!! $series->name !!}" :successMessage="$successMessage">
    <div class="d-flex justify-content-between">
        <div class="d-flex flex-column gap-2 text-light">
            <h1 class="text-light fw-bold mb-0" style="font-family: 'Nunito', sans-serif">{{ $series->name }}</h1>
            <div class="d-flex gap-1">
                @forEach($series->categories as $category)
                    <span class="d-flex align-items-center bg-dark rounded text-light" style="font-size: 0.7rem; padding: 1px 4px;">{{ $category->name }}</span>
                @endforeach
                <div class="d-flex align-items-center ms-1">
                    <span>{{ $series->averageRating() }}</span>
                    <i class="bx bxs-star text-yellow-500" style="margin-bottom: 1px; margin-left: 1px;"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-1">
                <p class="m-0 text-gray-400" style="font-size: 0.8rem">Rate this series:</p>

                @for ($i = 1; $i <= 5; $i++)
                    <button class="rating-star-button" rating-value="{{ $i }}">
                        <i class='bx {{ $i <= $rating ? "bxs-star text-primary" : "bx-star text-gray-700" }} star-icon'></i>
                    </button>
                @endfor
            </div>
            <p class="small" style="text-align: justify">{{ $series->synopsis }}</p>
        </div>

        <img
            src="{{ asset($series->cover) }}"
            alt="Series cover"
            class="img-fluid"
            style="height: 250px"
        >
    </div>

    <select
        id="season"
        name="season"
        class="bg-dark text-light rounded-2 border-0 dark-input mb-2"
        style="cursor: pointer"
    >
        @foreach ($seasons as $season)
            <option
                value="{{ $season->id }}"
                class="bg-dark text-light rounded"
            >
                Season {{ $season->number }}
            </option>
        @endforeach
    </select>

    <section id="carousel-container">
        <div class="owl-carousel">
            @foreach ($episodes as $episode)
                <li class="list-item d-flex align-items-center gap-2" style="margin: 2px">
                    <div class="bg-black rounded episode-card">
                        <img
                            src="{{ asset($series->cover) }}"
                            alt="{{ $series->name }} cover"
                            class="rounded-top"
                        >
                        <div class="d-flex align-items-center p-1">
                            <p class="text-gray-300 m-0">
                                Episode {{ $episode->number }} {{ $episode->id }}
                            </p>
                        </div>
                    </div>
                </li>
            @endforeach
        </div>
    </section>

    <script>
        var series = @json([
            'id' => $series->id,
            'name' => $series->name,
            'cover' => asset($series->cover)
        ])
    </script>

    <script src="{{ mix('js/seasons-select.js') }}"></script>

    <script>
        const ratingButtons = document.querySelectorAll('.rating-star-button');

        ratingButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                let rating = this.getAttribute('rating-value');

                fetch(`/user/rate-series/${series.id}?rate=${rating}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    ratingButtons.forEach(button => {
                        const starIcon = button.querySelector('.star-icon');
                        console.log(data.rating)

                        let value = button.getAttribute('rating-value');

                        if (value <= data.rating) {
                            starIcon.classList.remove('bx-star', 'text-gray-700');
                            starIcon.classList.add('bxs-star', 'text-primary');
                        } else {
                            starIcon.classList.remove('bxs-star', 'text-primary');
                            starIcon.classList.add('bx-star', 'text-gray-700');
                        }
                    });

                    console.log('salvo');
                });
            });
        });
    </script>
</x-layout>

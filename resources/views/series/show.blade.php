<x-layout title="SeriesFlix - {!! $series->name !!}" :successMessage="$successMessage">
    <div class="d-flex justify-content-between">
        <div class="d-flex flex-column gap-2 text-light">
            <h1 class="text-light fw-bold mb-0" style="font-family: 'Nunito', sans-serif">{{ $series->name }}</h1>
            <div class="d-flex gap-1">
                @forEach($series->categories as $category)
                    <span class="bg-dark rounded text-light" style="font-size: 0.7rem; padding: 1px 4px;">{{ $category->name }}</span>
                @endforeach
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
            'name' => $series->name,
            'cover' => asset($series->cover)
        ])
    </script>

    <script src="{{ mix('js/seasons-select.js') }}"></script>
</x-layout> 
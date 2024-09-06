<x-layout title="SeriesFlix - {!! $series->name !!}" :successMessage="$successMessage">
    <div class="d-flex justify-content-between">
        <h1 class="text-light fw-bold" style="font-family: 'Nunito', sans-serif">{{$series->name}}</h1>
    
        <img 
            src="{{ asset($series->cover) }}" 
            alt="Series cover"
            class="img-fluid"
            style="height: 250px"
        >
    </div>

    <form action="{{ route('seasons.index', $series->id) }}" class="mb-2">
        <select 
            id="Season" 
            name="Season" 
            class="bg-dark text-light rounded-2 border-0 dark-input"
            style="cursor: pointer"
        >
            @foreach ($seasons as $season)
                <option 
                    value="{{ $season->number }}"
                    class="bg-dark text-light rounded"
                >
                    Season {{ $season->number }}
                </option>
            @endforeach
        </select>
    </form>

    <section id="carousel-container">

        <div class="owl-carousel" style="overflow: visible">
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
                                Episode {{ $episode->number }}
                            </p>
                        </div>
                    </div>
                </li>
            @endforeach
        </div>

    </section>
</x-layout> 
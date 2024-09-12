<x-layout title="SeriesFlix" :successMessage="$successMessage">

    <div class="d-flex align-items-center justify-content-between px-2">
        <h1 class="text-light fw-bold" style="font-family: 'Nunito', sans-serif">Catalog</h1>
        
        @auth
        <a 
            href="{{ route('series.create') }}" 
            class="btn btn-dark btn-sm fw-bold d-flex justify-content-center align-items-center pb-auto" 
            style="border-radius: 20px; width: 25px; height: 25px; top: 50%; left: 50%; font-size: 18px"
            title="Add series"
        >
            <i class='bx bx-plus' ></i>
        </a>
        @endauth
    </div>

    <form action="{{ route('series.index') }}" method="GET" class="d-flex mb-3" style="height: 30px;">
        <input 
            id="seriesSearch"
            type="text" 
            name="name" id="name" 
            class="form-control w-100 bg-dark text-light dark-input" 
            style="
                height: fit-content; 
                font-size: 12px; 
                border-top-left-radius: 15px; 
                border-bottom-left-radius: 15px;
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
                border: none;
            "
            placeholder="Search for a title..."
            value="{{ $name }}"
        >
        <button 
            type="submit" 
            class="btn btn-dark bg-primary d-flex justify-content-center align-items-center search-button"
            style="border-radius: 20px; border-top-left-radius: 0; border-bottom-left-radius: 0;"
            title="Search"
        >
            <i class='bx bx-search' style="font-size: 1.1rem; font-weight: bold; margin-right: 3px"></i>
        </button>
    </form>

    @if (count($seriesArray) > 0)
        <ul id="series-list" class="d-flex flex-column gap-2 px-0">
            @foreach ($seriesArray as $series)
                <li 
                    id="series"
                    class="d-flex justify-content-between align-items-center p-0" 
                    style="height: 60px; box-shadow: 0px 0px 3px 1px #252525; border-radius: 10px; padding: 7px 12px; cursor: pointer;"
                >
                    <a href="{{ route('seasons.index', $series->id) }}" class="text-decoration-none text-light w-100">
                        <div class="d-flex gap-2 align-items-center">
                            <img 
                                src="{{ asset($series->cover) }}" 
                                alt="{{ $series->name }} cover"
                                style="width: 100px; height: 60px; object-fit: cover; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"
                            >
                            {{ $series->name }}
                        </div>
                    </a>

                    @auth
                    <div id="series-buttons" class="d-flex gap-2 align-items-center h-100" style="display: none;">
                        <a 
                            href="{{ route('series.edit', $series->id) }}"
                            class="btn btn-sm d-flex align-items-center"
                            style="width: 1.2rem; background-color: transparent; padding: 0;"
                        >
                            <i class='bx bxs-pencil bx-xs series-icon-button' title="Edit"></i>
                        </a>
            
                        <form action="{{ route('series.destroy', $series->id) }}" method="POST" style="width: fit-content; height: fit-content;">
                            @csrf
                            @method('DELETE')
                            <button 
                                class="btn btn-sm d-flex justify-content-center align-items-center p-0" 
                                style="width: 1.2rem; height: 1.2rem; background-color: transparent;"
                            >
                                <i class='bx bxs-trash-alt bx-xs series-icon-button' title="Delete"></i>
                            </button>
                        </form>

                        <a 
                            href="{{ route('seasons.index', $series->id) }}"
                            class="d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none"  
                            style="width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
                        >
                            <i class='bx bxs-chevron-right text-secondary' ></i>
                        </a>
                    </div>
                    @endauth

                </li>
            @endforeach
        </ul>

        <div id="series-nav-bar" class="d-flex justify-content-center align-items-center gap-3 pt-3 pb-3" style="width: 100%">
            <a 
                href="{{ $previousPageUrl }}" 
                class="btn d-flex align-items-center justify-content-center text-decoration-none @if (!isset($previousPageUrl)) disabled @endif"
                style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none;"
            >
                <i class='bx bxs-left-arrow text-primary' title="Previous page"></i>
            </a>
    
            <div class="d-flex gap-2">
                @for ($i = 1; $i <= $lastPage; $i++)
                    <a 
                        href="{{ $seriesArray->url($i) }}"
                        class="text-decoration-none text-primary"
                        style="@if ($i !== $currentPage) opacity: 50%; @endif"
                    >
                        {{ $i }}
                    </a>
                @endfor
            </div>
    
            <a 
                href="{{ $nextPageUrl }}" 
                class="btn d-flex align-items-center justify-content-center text-decoration-none @if (!isset($nextPageUrl)) disabled @endif"
                style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none;"
            >
                <i class='bx bxs-right-arrow text-primary' title="Next page"></i>
            </a>
        </div>
    @elseif (request()->has('name'))
        <div class="d-flex justify-content-center mt-4">
            <p class="text-light">No series with the name '{{ request('name') }}' were found</p>
        </div>
    @else
        <div class="d-flex justify-content-center mt-4">
            <p class="text-light">Your series list is empty. Add series to watch</p>
        </div>
    @endif

    {{-- var seriesIndexUrl = "{{ route('series.index') }}";
    var csrfToken = "{{ csrf_token() }}";
    var lastPage = {{ $lastPage ?? 1 }};
    var currentPage = {{ $currentPage ?? 1 }};
    var isAuthenticated = @auth true @else false @endauth; --}}

    <script>
        let typingTimer;

        document.getElementById('seriesSearch').addEventListener('input', function() {
            clearTimeout(typingTimer);

            const seriesName = this.value;

            typingTimer = setTimeout(function() {
                fetch(`{{ route('series.index') }}?name=${seriesName}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(series => {
                    const seriesList = document.getElementById('series-list');
                    seriesList.innerHTML = '';

                    if (series['data'].length > 0) {
                        series['data'].forEach(series => {
                            const seriesItem = `
                                <li 
                                    id="series"
                                    class="d-flex justify-content-between align-items-center p-0" 
                                    style="height: 60px; box-shadow: 0px 0px 3px 1px #252525; border-radius: 10px; padding: 7px 12px; cursor: pointer;"
                                >
                                    <a href="/series/${series.id}/seasons" class="text-decoration-none text-light w-100">
                                        <div class="d-flex gap-2 align-items-center">
                                            <img 
                                                src="${series.cover}" 
                                                alt="${series.name} cover"
                                                style="width: 100px; height: 60px; object-fit: cover; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"
                                            >
                                            ${series.name}
                                        </div>
                                    </a>

                                    @auth
                                    <div id="series-buttons" class="d-flex gap-2 align-items-center h-100" style="display: none;">
                                        <a 
                                            href="/series/${series.id}/edit"
                                            class="btn btn-sm d-flex align-items-center"
                                            style="width: 1.2rem; background-color: transparent; padding: 0;"
                                        >
                                            <i class='bx bxs-pencil bx-xs series-icon-button' title="Edit"></i>
                                        </a>
                            
                                        <form action="/series/${series.id}" method="POST" style="width: fit-content; height: fit-content;">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                class="btn btn-sm d-flex justify-content-center align-items-center p-0" 
                                                style="width: 1.2rem; height: 1.2rem; background-color: transparent;"
                                            >
                                                <i class='bx bxs-trash-alt bx-xs series-icon-button' title="Delete"></i>
                                            </button>
                                        </form>

                                        <a 
                                            href="/seasons/${series.id}"
                                            class="d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none"  
                                            style="width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
                                        >
                                            <i class='bx bxs-chevron-right text-secondary' ></i>
                                        </a>
                                    </div>
                                    @endauth

                                </li>
                            `;
                            seriesList.innerHTML += seriesItem;
                        })
                        
                        const seriesNavBar = document.getElementById('series-nav-bar');
                            seriesNavBar.innerHTML = '';

                            seriesNavBar.innerHTML = `
                                <a 
                                    href="${series.prev_page_url}" 
                                    class="btn d-flex align-items-center justify-content-center text-decoration-none @if (!isset($previousPageUrl)) disabled @endif"
                                    style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none;"
                                >
                                    <i class='bx bxs-left-arrow text-primary' title="Previous page"></i>
                                </a>
                        
                                <div class="d-flex gap-2">
                                    @for ($i = 1; $i <= $lastPage; $i++)
                                        <a 
                                            href="{{ $seriesArray->url($i) }}"
                                            class="text-decoration-none text-primary"
                                            style="@if ($i !== $currentPage) opacity: 50%; @endif"
                                        >
                                            {{ $i }}
                                        </a>
                                    @endfor
                                </div>
                        
                                <a 
                                    href="${series.next_page_url}" 
                                    class="btn d-flex align-items-center justify-content-center text-decoration-none @if (!isset($nextPageUrl)) disabled @endif"
                                    style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none;"
                                >
                                    <i class='bx bxs-right-arrow text-primary' title="Next page"></i>
                                </a>
                            `;
                    } else {
                        const noResultsMessage = `
                            <div class="d-flex justify-content-center mt-4">
                                <p class="text-light">No series with the name '${seriesName}' were found</p>
                            </div>
                        `;
                        seriesList.innerHTML = noResultsMessage;
                    }
                })
                .catch(error => console.log('Error:', error));
            }, 2000)
        })
    </script>

</x-layout>
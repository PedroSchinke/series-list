<x-layout title="SeriesFlix" :successMessage="$successMessage">
    <div class="d-flex align-items-center justify-content-between px-2">
        <h1 class="text-light fw-bold" style="font-family: 'Nunito', sans-serif">Catalog</h1>
        
        <a 
            href="{{ route('series.create') }}" 
            class="btn btn-dark btn-sm fw-bold d-flex justify-content-center align-items-center pb-auto" 
            style="border-radius: 20px; width: 25px; height: 25px; top: 50%; left: 50%; font-size: 18px"
            title="Add series"
        >
            <i class='bx bx-plus' ></i>
        </a>
    </div>

    <form action="{{ route('series.index') }}" method="GET" class="d-flex flex-column gap-1 mb-2" style="height: 60px;">
        <div class="d-flex align-items-center w-100 h-50">
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
                class="btn btn-dark bg-primary d-flex justify-content-center align-items-center search-button h-100"
                style="border-radius: 20px; border-top-left-radius: 0; border-bottom-left-radius: 0;"
                title="Search"
            >
                <i class='bx bx-search' style="font-size: 1.1rem; font-weight: bold; margin-right: 3px"></i>
            </button>
        </div>
        <div class="d-flex align-items-center justify-content-between h-50">
            <div class="d-flex align-items-center justify-content-center gap-2 h-75">
                <button 
                    type="button" 
                    id="favorite-toggle" 
                    class="btn d-flex align-items-center text-light bg-dark rounded-4 h-100 {{ $isFavoritesSelected ? 'selected' : null }}"
                    style="padding: 7px 10px; border: none;"
                >
                    <span id="favorite-label" class="text-light-m" style="font-size: 0.7rem;">Favorites</span>
                </button>
                <input type="hidden" name="favorites" id="favorites-selected" value="{{ $isFavoritesSelected ? '1' : '0' }}">

                <select 
                    id="categories"
                    class="bg-dark text-gray-900 rounded-4 border-0 h-100 dark-select"
                    style="cursor: pointer; font-size: 0.7rem; width: fit-content; padding: 0 25px 0 10px;"
                >
                    <option id="default-option" class="bg-dark fst-italic rounded">Categories (max.4)</option>
                    @forEach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <input type="hidden" name="categories" id="selected-categories">
    
                <div id="categories-selected-container" class="d-flex align-items-center gap-1" style="font-size: 0.7rem"></div>
            </div>

            <button 
                type="submit" 
                class="btn d-flex align-items-center bg-primary text-light rounded-4 search-button h-75"
                style="font-size: 0.7rem; padding: 0 8px;"
            >
                <span>Filter</span>
                <i class='bx bx-filter-alt'></i>
            </button>
        </div>
    </form>

    @if (count($seriesArray) > 0)
        <ul id="series-list" class="d-flex flex-column gap-2 px-0">
            @foreach ($seriesArray as $series)
                <li 
                    class="d-flex justify-content-between align-items-center p-0 series" 
                    style="height: 60px; box-shadow: 0px 0px 3px 1px #252525; border-radius: 10px; padding: 7px 12px; cursor: pointer;"
                >
                    <a href="{{ route('series.show', $series->id) }}" class="text-decoration-none text-light w-100 series-card">
                        <div class="d-flex gap-2 align-items-center">
                            <img 
                                src="{{ asset($series->cover) }}" 
                                alt="{{ $series->name }} cover"
                                style="width: 100px; height: 60px; object-fit: cover; border-top-left-radius: 10px; border-bottom-left-radius: 10px;"
                            >
                            <button
                                data-series-id="{{ $series->id }}" 
                                class="bg-transparent favorite-button"
                                style="width: fit-content; height: fit-content;"
                                title="{{ $series->isFavorite ? 'Remove from favorites' : 'Add to favorites'}}"
                            >
                                <i class='bx {{ $series->isFavorite ? 'bxs-star text-primary' : 'bx-star text-light opacity-75'}} icon-favorite'></i>
                            </button>
                            <div class="d-flex flex-column">
                                {{ $series->name }}
                                <div class="d-flex gap-1">
                                    @forEach($series->categories as $category)
                                        <span class="bg-dark rounded" style="font-size: 0.5rem; padding: 1px 4px;">{{ $category->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="d-none gap-2 align-items-center h-100 series-buttons" style="display: none;">
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
                            href="{{ route('series.show', $series->id) }}"
                            class="d-flex align-items-center justify-content-center h-100 bg-primary text-decoration-none"  
                            style="width: 20px;border-top-right-radius: 10px; border-bottom-right-radius: 10px;"
                        >
                            <i class='bx bxs-chevron-right text-secondary' ></i>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>

        <section id="series-nav-bar" class="d-flex align-items-center justify-content-center gap-2">
            <a 
                href="{{ $seriesArray->previousPageUrl() }}" 
                class="btn d-flex align-items-center justify-content-center text-decoration-none {{ $seriesArray->previousPageUrl() === null ? 'disabled' : null }}"
                style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none; margin-top: 2px;"
            >
                <i class='bx bxs-left-arrow text-primary' title="Previous page"></i>
            </a>
            @for ($i = 1; $i <= $seriesArray->lastPage(); $i++)
                <a 
                    href="{{ $seriesArray->url($i) }}"
                    class="text-decoration-none text-primary"
                    style="@if ($i !== $seriesArray->currentPage()) opacity: 50%; @endif"
                >
                    {{ $i }}
                </a>
            @endfor
            <a 
                href="{{ $seriesArray->nextPageUrl() }}" 
                class="btn d-flex align-items-center justify-content-center text-decoration-none {{ $seriesArray->nextPageUrl() === null ? 'disabled' : null }}"
                style="height: 20px; font-size: 12px; height: 20px; padding: 0px 6px; border-radius: 6px; border: none; margin-top: 2px;"
            >
                <i class='bx bxs-right-arrow text-primary' title="Next page"></i>
            </a>
        </section>
    @elseif (request('name') !== '' || request('categories') !== '' || request('favorites') == 1)
        <div class="d-flex justify-content-center mt-4">
            <p class="text-light">No series with these filters were found</p>
        </div>
    @else
        <div class="d-flex justify-content-center mt-4">
            <p class="text-light">Your series list is empty. Add series to watch</p>
        </div>
    @endif

    <script src="{{ mix('js/search-bar.js') }}"></script>
    <script src="{{ mix('js/add-to-favorites-button.js') }}"></script>
    <script src="{{ mix('js/favorites-filter-button.js') }}"></script>

    @php
        $requestCategoriesArray = $requestCategories ? array_map('intval', explode(',', $requestCategories)) : [];
    @endphp

    <script>
        var categories = @json($requestCategoriesArray);
    </script>

    <script src="{{ mix('js/categories-select.js') }}"></script>
</x-layout>
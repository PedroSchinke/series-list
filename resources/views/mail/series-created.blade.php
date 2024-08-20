@component('mail::message')

# {{ $seriesName }} created

Series {{ $seriesName }} with {{ $seasonsQty }} seasons and {{ $episodesPerSeason }} episodes per season was created.

@component('mail::button', ['url' => route('seasons.index', $seriesId)])
    Watch series
@endcomponent

@endcomponent
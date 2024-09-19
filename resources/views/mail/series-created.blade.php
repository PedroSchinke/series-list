@component('mail::message')

# {{ $seriesName }} created

Series {{ $seriesName }} with {{ $seasons_qty }} seasons and {{ $episodes_per_season }} episodes per season was created.

@component('mail::button', ['url' => route('seasons.index', $seriesId)])
    Watch series
@endcomponent

@endcomponent
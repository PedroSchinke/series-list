<x-layout title="Editar série '{{ $serie->name }}'">
    <x-series.form :action="route('series.update', $serie->id)" :name="$serie->name"/>
</x-layout>

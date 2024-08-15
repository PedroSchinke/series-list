<x-layout title="New series">
    <x-series.form :action="route('series.store')" :name="old('name')" :update="false" />
</x-layout>

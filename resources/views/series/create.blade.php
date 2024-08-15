<x-layout title="Nova série">
    <x-series.form :action="route('series.store')" :name="old('name')" :update="false" />
</x-layout>

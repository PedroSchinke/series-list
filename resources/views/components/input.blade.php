@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'bg-secondary rounded-md shadow-sm border-0 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 dark-input']) !!}>

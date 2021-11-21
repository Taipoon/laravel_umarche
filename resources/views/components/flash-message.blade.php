@props(['status' => 'info'])

@php
if ($status === 'info') {
    $bgColor = 'bg-blue-300';
}
if ($status === 'error') {
    $bgColor = 'bg-red-500';
}

@endphp

@if (session('message'))
    <div class="{{ $bgColor }} mx-auto p-2 text-white w-1/2">
        {{ session('message') }}
    </div>
@endif

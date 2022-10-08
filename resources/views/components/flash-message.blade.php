@props(['status' => 'info'])

@php
if (session('status') === 'info') {
    $bgColor = 'bg-blue-300';
}
if (session('status') === 'alert') {
    $bgColor = 'bg-red-500';
}

@endphp

@if (session('message'))
    <div class="{{ $bgColor }} mx-auto p-2 mb-4 text-center text-white w-1/2">
        {{ session('message') }}
    </div>
@endif

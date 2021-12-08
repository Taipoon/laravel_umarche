<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('ホーム') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          {{-- Flash Message --}}
          <x-flash-message status="session('status')" />
          <div class="flex flex-wrap">
            @foreach ($products as $product)
              <div class="w-1/4 p-2 md-p-4">
                <a class="block relative h-48 rounded overflow-hidden">
                  <img alt="ecommerce" class="object-cover object-center w-full h-full block"
                    src="{{ asset('storage/products/' . $product->imageFirst->filename) }}">
                </a>
                <div class="mt-4">
                  <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category_name }}</h3>
                  <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                  <p class="mt-1"><span
                      class="text-sm">{{ number_format($product->price) }}円(税込)</span>
                  </p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

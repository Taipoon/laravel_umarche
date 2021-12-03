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
              <div class="w-1/2 md:w-1/3 md:p-4 p-2">
                <a href="">
                  <div class="border rouded-md p-4">
                    {{-- サムネイル画像 --}}
                    <x-thumbnail filename="{{ $product->imageFirst->filename ?? '' }}" type="products" />
                    <div class="text-gray-700">
                      {{ $product->name }}
                    </div>
                  </div>
                </a>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</x-app-layout>

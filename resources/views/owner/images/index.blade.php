<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    {{-- Flash Message --}}
                    <x-flash-message status="session('status')" />
                    <div class="flex justify-end mb-4">
                        <button
                            class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none mt-4 hover:bg-indigo-600 rounded text-lg"
                            onclick="location.href='{{ route('owner.images.create') }}'">新規登録する</button>
                    </div>
                    <div class="flex flex-wrap">
                        @foreach ($images as $image)
                            <div class="w-1/2 md:w-1/3 md:p-4 p-2">
                                <a href="{{ route('owner.images.edit', ['image' => $image->id]) }}">
                                    <div class="border rouded-md p-4">
                                        {{-- サムネイル画像 --}}
                                        <x-thumbnail :filename="$image->filename" type="products" />
                                        <div class="text-gray-700">
                                            {{ $image->title }}
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    {{ $images->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

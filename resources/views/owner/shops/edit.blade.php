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
                    {{-- Validation Errors --}}
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form action="{{ route('owner.shops.update', ['shop' => $shop->id]) }}"
                        accept="image/png,image/jpeg,image.jpg" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="-m-2">
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">店名 ※必須</label>
                                    <input type="text" id="name" name="name" required value="{{ $shop->name }}"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="information" class="leading-7 text-sm text-gray-600">店舗情報 ※必須</label>
                                    <textarea id="information" name="information" rows="10" required
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none focus:outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $shop->information }}</textarea>
                                </div>
                            </div>

                            <div class="w-1/2 p-2 mx-auto">
                                {{-- サムネイル画像 --}}
                                <x-thumbnail :filename="$shop->filename" type="shops" />
                            </div>
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                    <label for="image" class="leading-7 text-sm text-gray-600">画像</label>
                                    <input type="file" id="image" name="image"
                                        class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out focus:outline-none">
                                </div>
                            </div>

                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative flex justify-around">
                                    <div>
                                        <input type="radio" id="is_selling" name="is_selling" value="1"
                                            class="mr-2" @if ($shop->is_selling === '1') { checked } @endif><label
                                            for="is_selling">販売中</label>
                                    </div>
                                    <div>
                                        <input type="radio" name="is_selling" id="is_not_selling" value="0"
                                            class="mr-2" @if ($shop->is_selling === '0') { checked } @endif><label
                                            for="is_not_selling">停止中</label>
                                    </div>
                                </div>
                            </div>



                            <div class="flex justify-around p-2 w-full">
                                <button type="button" onclick="location.href='{{ route('owner.shops.index') }}'"
                                    class="text-black bg-gray-200 border-0 py-2 px-8 focus:outline-none mt-4 hover:bg-gray-400 rounded text-lg">戻る</button>
                                <button type="submit"
                                    class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none mt-4 hover:bg-indigo-600 rounded text-lg">更新する</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

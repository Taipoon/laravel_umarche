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
          <form action="{{ route('owner.products.store') }}" accept="image/png,image/jpeg,image.jpg" method="post"
            enctype="multipart/form-data">
            @csrf
            <div class="-m-2">
              <div class="p-2 w-1/2 mx-auto">
                <div class="relative">
                  <select name="category">
                    @foreach ($categories as $category)
                      <optgroup label="{{ $category->name }}">
                        @foreach ($category->secondary as $secondary)
                          <option value="{{ $secondary->id }}">{{ $secondary->name }}</option>
                        @endforeach
                      </optgroup>
                    @endforeach
                  </select>
                </div>
              </div>

              <x-select-image name="image1" :images="$images" />
              <x-select-image name="image2" :images="$images" />
              <x-select-image name="image3" :images="$images" />
              <x-select-image name="image4" :images="$images" />

              <div class="flex justify-around p-2 w-full">
                <button type="button" onclick="location.href='{{ route('owner.products.index') }}'"
                  class="text-black bg-gray-200 border-0 py-2 px-8 focus:outline-none mt-4 hover:bg-gray-400 rounded text-lg">戻る</button>
                <button type="submit"
                  class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none mt-4 hover:bg-indigo-600 rounded text-lg">登録する</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    'use strict'
    const images = document.querySelectorAll('.image');

    images.forEach(image => {
      image.addEventListener('click', function(e) {
        const imageName = e.target.dataset.id.substr(0, 6);
        const imageId = e.target.dataset.id.replace(imageName + '_', '');
        const imageFile = e.target.dataset.file;
        const imagePath = e.target.dataset.path;
        const modal = e.target.dataset.modal;

        // サムネイルと input type=hidden の value に設定
        document.getElementById(imageName + '_thumbnail').src = imagePath + '/' + imageFile;
        document.getElementById(imageName + '_hidden').value = imageId;
        MicroModal.close(modal); // モーダルウィンドウを閉じる
      })
    })
  </script>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            オーナー一覧
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="md:p-6 bg-white border-b border-gray-200">
                    <section class="text-gray-600 body-font">
                        <div class="container md:px-5 mx-auto">
                            {{-- Flash Message --}}
                            <x-flash-message status="session('status')" />

                            <div class="flex justify-end mb-4">
                                <button
                                    class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none mt-4 hover:bg-indigo-600 rounded text-lg"
                                    onclick="location.href='{{ route('admin.owners.create') }}'">新規登録する</button>
                            </div>
                            <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                                <table class="table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <tr>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">
                                                名前</th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                メールアドレス</th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">
                                                作成日</th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                            <th
                                                class="md:px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tr rounded-br">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($owners as $owner)
                                            <tr>
                                                <td class="md:px-4 py-3">{{ $owner->name }}</td>
                                                <td class="md:px-4 py-3">{{ $owner->email }}</td>
                                                <td class="md:px-4 py-3">{{ $owner->created_at->diffForHumans() }}
                                                </td>
                                                <td class="md:px-4 py-3">
                                                    <button
                                                        onclick="location.href='{{ route('admin.owners.edit', ['owner' => $owner->id]) }}'"
                                                        class="text-white bg-indigo-400 border-0 py-2 px-4 focus:outline-none mt-4 hover:bg-indigo-600 rounded text-lg">編集</button>
                                                </td>
                                                <form
                                                    action="{{ route('admin.owners.destroy', ['owner' => $owner->id]) }}"
                                                    id="delete_{{ $owner->id }}" method="post">
                                                    @method('DELETE')
                                                    @csrf
                                                    <td class="md:px-4 py-3">
                                                        <button onclick="deletePost(this)" href="#"
                                                            data-id="{{ $owner->id }}"
                                                            class="text-white bg-red-400 border-0 py-2 px-4 focus:outline-none mt-4 hover:bg-red-600 rounded text-lg">削除</button>
                                                    </td>
                                                </form>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $owners->links() }}
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deletePost(e) {
            'use strict';
            if (confirm('本当に削除してもいいですか?')) {
                document.getElementById('delete_' + e.dataset.id).submit();
            }
        }
    </script>
</x-app-layout>

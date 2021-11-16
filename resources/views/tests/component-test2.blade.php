<x-tests.app>
    <x-slot name="header">
        ヘッダー2
    </x-slot>
    コンポーネントテスト2 <br>
    <x-test-class-base classBaseMessage="クラスベースコンポーネントのメッセージだよ。"></x-test-class-base>
    <div class="mb-4"></div>
    <x-test-class-base classBaseMessage="クラスベースのメッセージ" defaultMessage="初期値から変更しています"></x-test-class-base>
    <a href="/component-test1">/component-test1</a>
</x-tests.app>

<!--
サブクラス(コンポーネントクラス+コンポーネント)をの使い方
これは、「コンポーネント」を使って最終的にControllerからreturnされるviewにあたるファイル。
-->
<x-tests.app>
    <x-slot name="header">
        ヘッダー1
    </x-slot>
    コンポーネントテスト1<br>
    <!-- コンポーネントをテンプレートではなく、部品として扱う。
    <x-コンポーネント名 変数名1="値" 変数名2="値" ...></x-コンポーネント名>として利用する
    -->

    <!-- DB等から値を取得して変数としてコントローラーから渡す場合の使い方
    blade.php(view)側では、属性に :コンポーネント側変数名 として、値には "$コントローラから渡ってくる変数" としなければならない。
    -->
    <x-tests.card title="タイトル" content="本文" :message="$message123"/>

    <!-- 属性の初期値は、コンポーネント側で用意する。初期値を用意しなければ、
   　　　　以下はエラーとなる。(Undefined variable: content) -->
    <x-tests.card title="タイトル2" />

    <!-- 一部だけblade.php(view)だけCSSを変更したい場合など -->
    <x-tests.card title="CSSを変更したい" class="font-bold bg-red-300" />

    <br>
    <a href="/component-test2">/component-test2</a>
</x-tests.app>


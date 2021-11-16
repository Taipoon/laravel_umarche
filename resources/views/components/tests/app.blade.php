<!--
サブクラス(コンポーネントクラス+コンポーネント)をの使い方。
これは、最終的にreturnされるviewのために用いるコンポーネントである。

コンポーネント(本ファイル)だけで使うこともできるが、
テンプレート継承のように様々なviewファイルで使いまわして、そのviewに応じて値を変更したり、
ヘッダやフッタを構成して、コンテンツ部分を「スロット」としてview側で作らせたりできる。
-->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header>
        <!-- 「名前付きスロット」
        マスタッシュ構文で $変数 としてスロットに名前を付与できる。
        blade.php(view)側では、<x-slot name="変数"></x-slot> として利用する。
        機能自体は、スロットと同じ。
        -->
        {{ $header }}
    </header>
    <div class="font-sans text-gray-900 antialiased">
        {{ $slot }}
        <!-- スロットとして使うパターン -->
        <!-- viewファイルで <x-コンポネント名></x-コンポーネント名>の中にコンテンツを入れることで、
        　　　その中のコンテンツが「スロット」に格納される。
        -->
    </div>
</body>
</html>

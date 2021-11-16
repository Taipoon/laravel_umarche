<!-- コンポーネントの使い方2．
blade.php(view)側で部品として使う。
マスタッシュ構文で1つ以上の変数を設定後、blade.php(view)側で
<x-コンポーネント名 変数名="値" 変数名2="値" ...></x-コンポーネント名>
として利用する。
-->

<!-- 初期値の設定。初期値はすべてに設定する必要がある。-->
@props([
   'title' => 'タイトル初期値',
   'content' => '本文初期値',
   'message' => 'メッセージ初期値',
])

<!-- タグの属性にマスタッシュ構文で $attributes と書くことで、blade.php(view)側で属性を個別設定できる。 -->
<!-- $attributes->merge([ 'コンポーネント側で設定する属性' => '値' ...]) と設定すれば、属性が共存可能。 -->
<!-- 上記のようにマージしない場合、blade.php 側の属性で上書きされてしまう。 -->

<div {{ $attributes->merge([
	'class' => 'border-2 shadow-md w-1/4 p-2',
]) }}>
    <div>{{ $title }}</div>
    <div>画像</div>
    <div>{{ $content }}</div>
    <div>{{ $message }}</div>
</div>

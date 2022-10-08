@php
if ($type === 'shops') {
    $path = 'storage/shops/';
    $description = '店舗画像';
} elseif ($type === 'products') {
    $path = 'storage/products/';
    $description = '商品画像';
}
@endphp


<div>
    @if (empty($filename))
        <img src="{{ asset('images/no_image.jpg') }}" alt="画像はありません">
    @else
        <img src="{{ asset($path . $filename) }}" alt="{{ $description }}">
    @endif
</div>

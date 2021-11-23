<div>
    @if (empty($filename))
        <img src="{{ asset('images/no_image.jpg') }}" alt="画像はありません">
    @else
        <img src="{{ asset('storage/shops/' . $filename) }}" alt="店舗画像">
    @endif
</div>

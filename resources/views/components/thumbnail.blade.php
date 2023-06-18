@php
if($type === 'shops'){
    $path = 'storage/shops/';
}
if($type === 'productss'){
    $path = 'storage/productss/';
}
@endphp
<div>
    @if(empty($filename))
        <img src="{{ asset('images/no_image.jpg') }}" >
    @else
        <img src="{{ asset($path . $filename) }}" >
    @endif
</div>

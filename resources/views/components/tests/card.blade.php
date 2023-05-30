<!-- 初期値の設定 -->
@props([
    'title'   => '',
    'message' => '初期値です。',
    'content' => '本文初期値です。'
    ])

<!-- 初期設定は残しつつ、部分的にCSSを変更したい場合は mergeメソッドを使用すると良い -->
<div {{ $attributes->merge([
    'class' => 'border-2 shadow-md w-/4 p-2'
]) }} > 
    <div>{{$title}}</div>
    <div>画像</div>
    <div>{{ $content }}</div>
    <div>{{ $message }}</div>
</div>
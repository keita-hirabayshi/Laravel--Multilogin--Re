<x-tests.app>
    <!-- appのコンポーネント内のslot枠に -->
    <x-slot name="header">ヘッダー1</x-slot>
    コンポーネントテスト1
<!-- 名前付きスロットでない属性の追加のみの場合は、属性名=値　と記載する -->
<!-- コントローラーから変数を渡す場合には、出力元で属性と区別するために : コロンと＄マークをつける -->
    <x-tests.card title="タイトル1" content="本文1" :message="$message" /> 
    <x-tests.card title="タイトル3" /> 
    <x-tests.card title="CSSを変更したいぞ" class="bg-blue-300" /> 
</x-tests.app>
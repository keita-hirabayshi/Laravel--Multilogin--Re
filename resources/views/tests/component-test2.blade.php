<x-tests.app>
    <x-slot name="header">ヘッダー2</x-slot>
    コンポーネントテスト2

    <x-test-class-base classBaseMessage="メッセージです" defaultMessage="なし"/>
    <div class="mb-4"></div>
    <!-- クラスベースの場合は、コンポーネントクラス内で、事前にプロパティを設定しないと、入力値を正しく読み込んでくれない -->
    <x-test-class-base classBaseMessage="メッセージです"  defaultMessage="初期値から変更しています" />
    
</x-tests.app>

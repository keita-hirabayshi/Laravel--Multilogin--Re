<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                商品一覧
            </h2>
            <div>
                <form method="get" action="{{ route('user.items.index')}}" >
                    <div class="flex">
                        <div>
                            <span class="text-sm">表示順</span><br>
                        <!-- idはjavascrip処理を行う際に必要となる -->
                            <select id="sort" name="sort" class="mr-4">
                               <option value="{{ \Constant::SORT_ORDER['recommend']}}"
                                @if(\Request::get('sort') === \Constant::SORT_ORDER['recommend'] )
                                selected
                                @endif>おすすめ順
                                </option> 
                                <option value="{{ \Constant::SORT_ORDER['higherPrice']}}"
                                @if(\Request::get('sort') === \Constant::SORT_ORDER['higherPrice'] )
                                selected
                                @endif>料金の高い順
                                </option> 
                                <option value="{{ \Constant::SORT_ORDER['lowerPrice']}}"
                                    @if(\Request::get('sort') === \Constant::SORT_ORDER['lowerPrice'] )
                                    selected
                                    @endif>料金の低い順
                                </option> 
                                <option value="{{ \Constant::SORT_ORDER['later']}}"
                                @if(\Request::get('sort') === \Constant::SORT_ORDER['later'] )
                                selected
                                @endif>新しい順
                                </option> 
                                <option value="{{ \Constant::SORT_ORDER['older']}}"
                                @if(\Request::get('sort') === \Constant::SORT_ORDER['older'] )
                                selected
                                @endif>古い順
                                </option> 
                            </select>
                        </div>
                        <div>
                            <span class="text-sm">表示件数</span><br>
                            <select id="pagination" name="pagination">
                                <option value="20"
                                @if(\Request::get('pagination') === '20')
                                selected
                                @endif>20件
                                </option>
                                <option value="50"
                                @if(\Request::get('pagination') === '50')
                                selected
                                @endif>50件
                                </option>
                                <option value="100"
                                @if(\Request::get('pagination') === '100')
                                selected
                                @endif>100件
                                </option>
                                
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                   <div class="flex flex-wrap">
                        @foreach($products as $product)
                        <div class="w-1/4  p-2 md:p-4">
                            <a href="{{ route('user.items.show', ['item' => $product->id]) }}">
                                <div class="border rounded-md p-2 md:p-4">
                                <!-- componentに文字列が入ってくる場合には、 filenameの : は外しておく -->
                                    <x-thumbnail filename="{{$product->filename ?? '' }}" type="products" /> 
                                    <div class="mt-4">
                                        <h3 class="text-gray-500 text-xs tracking-widest title-font mb-1">{{ $product->category }}</h3>
                                        <h2 class="text-gray-900 title-font text-lg font-medium">{{ $product->name }}</h2>
                                        <p class="mt-1">{{ number_format($product->price) }}<span class="text-sm text-gray-700">円(税込)</span></p>
                                        
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                <!-- appendメソッドを使用することで、指定の値を引き継げる -->
                    {{ $products->appends([
                        'sort' => \Request::get('sort'),
                        'pagination' => \Request::get('pagination')
                        ])->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- <-- idが変更されたら、formを送信する --> 
    <script>
        const select = document.getElementById('sort')
        select.addEventListener('change', function(){
        this.form.submit()
        })
        const paginate = document.getElementById('pagination')
        paginate.addEventListener('change', function(){
        this.form.submit()
        })
    </script>
</x-app-layout>

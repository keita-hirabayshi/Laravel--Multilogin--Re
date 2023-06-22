<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
         
                    <form action="{{ route('owner.products.store')}}" method="post">
                    @csrf
                        <div class="-m-2">
                            <div class="p-2 w-1/2 mx-auto">
                                <div class="relative">
                                <select name="category">
                                    @foreach($categories as $category)
                                      <optgroup label="{{ $category->name }}">
                                        @foreach($category->secondary as $secondary)
                                            <option value="{{ $secondary->id}}" >
                                             {{ $secondary->name }}
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>
                              
                                <div class="p-2 mt-4 flex justify-between w-full ">        
                                    <button type="button" onclick="location.href='{{ route('owner.products.index')}}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                                    <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
                                </div>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->tinyInteger('type');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_stocks');
    }
};

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
                                  <label for="name" class="leading-7 text-sm text-gray-600">商品名 ＊必須</label>
                                  <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full required bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                              </div>
                              <div class="relative">
                                  <label for="information" class="leading-7 text-sm text-gray-600">商品情報 ＊必須</label>
                                  <textarea  id="information" name="information" rows="10" required class="w-full required bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ old('information') }}</textarea>
                                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                              </div>
                          </div>
                          <div class="relative">
                              <label for="price" class="leading-7 text-sm text-gray-600">価格 ＊必須</label>
                              <input type="text" id="price" name="price" value="{{ old('price') }}" required class="w-full required bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              <x-input-error :messages="$errors->get('name')" class="mt-2" />
                          </div>
                          <div class="relative">
                              <label for="sort_order" class="leading-7 text-sm text-gray-600">表示順</label>
                              <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order') }}" class="w-full required bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              <x-input-error :messages="$errors->get('name')" class="mt-2" />
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                              <div class="relative">
                                  <select name="category">
                                  @foreach($shops as $shop)
                                  <option value="{{ $shop->id}}" >
                                      {{ $shop->name }}
                                  </option>
                                  @endforeach
                                  </select>
                              </div>    
                          </div>    
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
                              <!-- componetにコントローラーからくる、配列を渡したい場合hには :images のように表記すると可能 -->
                                  <x-input-error :messages="$errors->get('name')" class="mt-2" />
                              </div>
                          </div>
                          <x-select-image :images="$images" name="image1" />
                          <x-select-image :images="$images" name="image2" />
                          <x-select-image :images="$images" name="image3" />
                          <x-select-image :images="$images" name="image4" />
                          <x-select-image :images="$images" name="image5" />
                          <div class="p-2 w-1/2 mx-auto">
                              <div class="relative flex justify-around">
                                  <div><input type="radio" name="is_selling" value="1" class="mr-2" @if($shop->is_selling === 1){ checked } @endif >販売中</div>
                                  <div><input type="radio" name="is_selling" value="0" class="mr-2" @if($shop->is_selling === 0) @endif >停止中</div>
                              </div>
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
  <script>
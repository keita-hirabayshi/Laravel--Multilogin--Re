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
                    エロクエント
                    @foreach($e_all as $e_owner)
                     {{ $e_owner->name}}
                      {{ $e_owner->created_at->diffForHumans()}}
                    @endforeach
                    <br>
            <!-- クエリビルダではcarbonインスタンスと認識させるために、文頭にCarbon指定する必要がある -->
                    クエリビルダ
                    @foreach($q_get as $q_owner)
                     {{ $q_owner->name}}
                      {{ Carbon\Carbon::parse($q_owner->created_at)->diffForHumans()}}
                    @endforeach
                    </br>
                    <br>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>

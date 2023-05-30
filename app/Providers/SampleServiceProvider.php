<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SampleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
// registerメソッド内に記載することで、サービスコンテナにメソッドが登録されるようになる
    public function register()
    {
        app()->bind('serviceProviderTest',function(){
            return 'サービスプロバイダーのテスト';
        });

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

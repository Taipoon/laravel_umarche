<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SampleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * config/app.php の prividersに登録してあれば
         * アプリ起動時に自動的に実行され、
         * サービスコンテナへの登録も自動的に実行される。
         */
        app()->bind('serviceProviderTest', function(){
            return 'サービスプロバイダのテスト';
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

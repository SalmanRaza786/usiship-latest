<?php

namespace App\Providers;

use App\Models\Language;
use App\Repositries\appSettings\AppSettingsRepositry;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppSettingInfoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $app= new AppSettingsRepositry();
        $res=$app->getAppSettings();
        View::share('appInfo',$res->get('data'));
    }
}

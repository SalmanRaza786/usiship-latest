<?php

namespace App\Providers;

use App\Events\SendEmailEvent;
use App\Listeners\SendEmailListener;
use App\Repositries\appointment\AppointmentInterface;
use App\Repositries\appointment\AppointmentRepositry;
use App\Repositries\appSettings\AppSettingsInterface;
use App\Repositries\appSettings\AppSettingsRepositry;
use App\Repositries\carriers\CarriersInterface;
use App\Repositries\carriers\CarriersRepositry;
use App\Repositries\checkIn\CheckInInterface;
use App\Repositries\checkIn\CheckInRepositry;
use App\Repositries\companies\CompaniesInterface;
use App\Repositries\companies\CompaniesRepositry;
use App\Repositries\customer\CustomerInterface;
use App\Repositries\customer\CustomerRepositry;
use App\Repositries\customField\CustomFieldInterface;
use App\Repositries\customField\CustomFieldRepositry;
use App\Repositries\dock\DockInterface;
use App\Repositries\dock\DockRepositry;
use App\Repositries\loadType\loadTypeInterface;
use App\Repositries\loadType\loadTypeRepositry;

use App\Repositries\offLoading\OffLoadingInterface;
use App\Repositries\offLoading\OffLoadingRepositry;


use App\Repositries\notification\NotificationInterface;
use App\Repositries\notification\NotificationRepositry;


use App\Repositries\orderContact\OrderContactInterface;
use App\Repositries\orderContact\OrderContactRepositry;

use App\Repositries\packagingList\PackagingListInterface;
use App\Repositries\packagingList\PackagingListRepositry;
use App\Repositries\permissions\PermissionInterface;
use App\Repositries\permissions\PermissionRepositry;
use App\Repositries\putaway\PutAwayInterface;
use App\Repositries\putaway\PutawayRepositry;
use App\Repositries\roles\RoleInterface;
use App\Repositries\roles\RoleRepositry;
use App\Repositries\user\UserInterface;
use App\Repositries\user\UserRepositry;
use App\Repositries\wh\WhInterface;
use App\Repositries\wh\WhRepositry;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(AppSettingsInterface::class,AppSettingsRepositry::class);
        $this->app->bind(PermissionInterface::class,PermissionRepositry::class);
        $this->app->bind(RoleInterface::class,RoleRepositry::class);
        $this->app->bind(UserInterface::class,UserRepositry::class);
        $this->app->bind(WhInterface::class,WhRepositry::class);
        $this->app->bind(loadTypeInterface::class,loadTypeRepositry::class);
        $this->app->bind(CustomerInterface::class,CustomerRepositry::class);
        $this->app->bind(CustomFieldInterface::class,CustomFieldRepositry::class);

        $this->app->bind(CompaniesInterface::class,CompaniesRepositry::class);
        $this->app->bind(CarriersInterface::class,CarriersRepositry::class);

        $this->app->bind(DockInterface::class,DockRepositry::class);
        $this->app->bind(AppointmentInterface::class,AppointmentRepositry::class);
        $this->app->bind(NotificationInterface::class,NotificationRepositry::class);

        $this->app->bind(OrderContactInterface::class,OrderContactRepositry::class);
        $this->app->bind(CheckInInterface::class,CheckInRepositry::class);
        $this->app->bind(OffLoadingInterface::class,OffLoadingRepositry::class);

        $this->app->bind(PackagingListInterface::class,PackagingListRepositry::class);

        $this->app->bind(PutAwayInterface::class,PutawayRepositry::class);



    }
}

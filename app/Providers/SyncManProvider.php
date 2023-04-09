<?php


namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Auth;


class SyncManProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


        Blade::if('role', function (string $role) {
            if($role == 'guest') {
                return ! Auth::check();
            }
            return Auth::check() && Auth::user()->hasRole($role); 
        });
        
        
        Blade::directive('endview', function () {
            return "<?php endif; ?>";
        });

        $this->app->bind('SyncMan', function ($app) {
            return new \App\Hydraulics\SyncMan($app->make(\App\Hydraulics\AirBooker::class),
            $app->make(\App\Hydraulics\Syncer::class));
        });

        $this->app->bind('CampMan', function ($app) {
            return new \App\Hydraulics\CampaignMan($app->make(\App\Hydraulics\CampaignProvider::class));
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Opps;
use App\Models\Campaign;
use App\Models\Contact;
use App\Models\VideoAudit;
use App\Observers\OppsObserver;
use App\Observers\VideoAuditObserver;
use App\Observers\CampaignObserver;
use App\Observers\ContactObserver;
use App\Models\Touchpoint;
use App\Observers\TouchpointObserver;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Blade;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if ($this->app->environment('local')) {
        }
     
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('components.mycomponent', 'mycomponent');
        Opps::observe(OppsObserver::class);
        Campaign::observe(CampaignObserver::class);
        Contact::observe(ContactObserver::class);
        Cashier::useCustomerModel(User::class);
        VideoAudit::observe(VideoAuditObserver::class);
        Touchpoint::observe(TouchpointObserver::class);
        Cashier::calculateTaxes();
        \Debugbar::disable();
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use SimonHamp\LaravelNovaCsvImport\LaravelNovaCsvImport;
use Devour\Datagrid\Datagrid;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Image;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use Oneduo\NovaFileManager\NovaFileManager;



class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Nova::withoutNotificationCenter();
        Nova::initialPath('/resources/campaigns');
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {

            /*return in_array($user->email, [
                'kosta@headstudios.com.au'
            ]);*/
            return true;
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            (new \App\Nova\Dashboards\Main)->canSee(function ($request) {
                return $request->user()->hasRole('admin');
            }),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
            (new LaravelNovaCsvImport)->canSee(function ($request) {
                return auth()->user()->hasRole('admin');
            }),
            (new Datagrid)->canSee(function ($request) {
                return auth()->user()->hasRole('admin');
            }),
            NovaFileManager::make(),
            
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

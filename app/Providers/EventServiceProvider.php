<?php

namespace App\Providers;

use App\Events\CourseAttachedToUser;
use App\Listeners\EmailUserAboutCourseAttach;
use Illuminate\Auth\Events\Registered;
use AshAllenDesign\ShortURL\Events\ShortURLVisited;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use App\Listeners\PhoneMessageLinkClicked;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\ButtonEar;
use Dnwjn\NovaButton\Events\ButtonClick;
use App\Models\Opps;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ShortURLVisited::class => [
            PhoneMessageLinkClicked::class,
        ],
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\CheckStripeTag',
            ],
            CourseAttachedToUser::class => [
                EmailUserAboutCourseAttach::class,
        ],
        ButtonClick::class => [
            ButtonEar::class,
        ],
        
            
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
       
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}

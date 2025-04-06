<?php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Events\UserLoggedIn;
use App\Listeners\UpdateUserStatus;
use App\Events\UserOnlineStatusChanged;
use App\Listeners\BroadcastUserStatus;

class EventServiceProvider extends ServiceProvider
{   
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
     protected $listen = [
    Login::class => [UpdateUserStatus::class],
    Logout::class => [UpdateUserStatus::class],
];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
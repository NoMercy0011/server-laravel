<?php

namespace App\Providers;

use App\Events\CommandeCreate;
use App\Events\DevisLivreCreate;
use App\Events\TestEventReverb;
use App\Listeners\NotificationCommandeCreate;
use App\Listeners\SendDevisLivreNotification;
use App\Listeners\TestActionToSocket;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        TestEventReverb::class => [
            TestActionToSocket::class,
        ],
        DevisLivreCreate::class => [
            SendDevisLivreNotification::class,
        ],
        
        CommandeCreate::class => [
            NotificationCommandeCreate::class,
        ],
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

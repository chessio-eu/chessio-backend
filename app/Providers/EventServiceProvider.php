<?php

namespace App\Providers;

use App\Events\PieceMoved;
use App\Events\PlayerJoinedGame;
use App\Events\PlayerJoiningGame;
use App\Events\SecondPlayerJoinedGame;
use App\Listeners\CheckKingStatus;
use App\Listeners\ProcessGame;
use App\Listeners\SetupPlayerColor;
use App\Models\Piece;
use App\Models\Player;
use App\Observers\PieceObserver;
use App\Observers\PlayerObserver;
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
        PlayerJoiningGame::class => [
            SetupPlayerColor::class
        ],
        PlayerJoinedGame::class => [
            ProcessGame::class
        ],
        PieceMoved::class => [
            CheckKingStatus::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Piece::observe(PieceObserver::class);
        Player::observe(PlayerObserver::class);
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

<?php

namespace App\Support\CurrentPlayer\Providers;

use App\Events\PlayerJoinedGame;
use App\Support\CurrentPlayer\Adapters\SessionPlayer;
use App\Support\CurrentPlayer\Contracts\PlayerAdapter;
use App\Support\CurrentPlayer\CurrentPlayer;
use App\Support\CurrentPlayer\Listeners\SetCurrentPlayer as SetCurrentPlayerListener;
use Illuminate\Support\ServiceProvider;

class CurrentPlayerProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(PlayerAdapter::class, fn () => app(match (config('game.current_player.driver')) {
            'session' => SessionPlayer::class
        }));

        $this->app->singleton(CurrentPlayer::class);
    }

    public function boot(): void {
        $this->app['events']->listen(PlayerJoinedGame::class, SetCurrentPlayerListener::class);
    }
}

<?php

namespace Tests\Unit\Support\CurrentPlayer\Providers;

use App\Support\CurrentPlayer\Adapters\SessionPlayer;
use App\Support\CurrentPlayer\Contracts\PlayerAdapter;
use App\Support\CurrentPlayer\CurrentPlayer;
use App\Support\CurrentPlayer\Providers\CurrentPlayerProvider;
use Tests\TestCase;

class CurrentPlayerProviderTest extends TestCase
{
    function test_it_registers_singleton_current_player_service() {
        $provider = new CurrentPlayerProvider($this->app);
        $provider->register();

        $intance1 = app(CurrentPlayer::class);
        $intance2 = app(CurrentPlayer::class);

        $this->assertSame($intance1, $intance2);
    }

    function test_it_binds_session_player_to_http_player() {
        $provider = new CurrentPlayerProvider($this->app);

        \Config::set('game.current_player.driver', 'session');

        $provider->register();

        $this->assertInstanceOf(SessionPlayer::class, $this->app->make(PlayerAdapter::class));
    }
}

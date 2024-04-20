<?php

namespace Tests\Unit\Support\CurrentPlayer\Providers;

use App\Support\CurrentPlayer\Adapters\CookiePlayer;
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

    function test_it_binds_cookie_player_to_http_player() {
        $provider = new CurrentPlayerProvider($this->app);

        \Config::set('game.current_player.driver', 'cookie');

        $provider->register();

        $this->assertInstanceOf(CookiePlayer::class, $this->app->make(PlayerAdapter::class));
    }
}

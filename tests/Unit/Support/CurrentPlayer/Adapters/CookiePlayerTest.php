<?php

namespace Unit\Support\CurrentPlayer\Adapters;

use App\Support\CurrentPlayer\Adapters\CookiePlayer;
use Config;
use Database\Factories\PlayerFactory;
use Illuminate\Http\Request;
use Tests\TestCase;

class CookiePlayerTest extends TestCase {
    function test_it_retrieves_player_from_cookie() {
        $cookieName = 'cookieName';

        Config::set('game.current_player.cookie_name', $cookieName);
        $expectedPlayer = PlayerFactory::new()->create();
        $this->spy(Request::class)->shouldReceive('cookie')->with($cookieName)->andReturn($expectedPlayer->id);

        $cookiePlayer = $this->app->make(CookiePlayer::class);

        $actualPlayer = $cookiePlayer->retrieve();
        $this->assertEquals($expectedPlayer->id, $actualPlayer->id);
    }

    function test_it_queues_cookie_on_set() {
        $cookieName = 'cookieName';

        Config::set('game.current_player.cookie_name', $cookieName);
        $player = PlayerFactory::new()->create();
        $cookiePlayer = $this->app->make(CookiePlayer::class);
        $cookiePlayer->set($player);

        $this->get('/')->assertCookie($cookieName, $player->id);
    }
}

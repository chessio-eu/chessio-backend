<?php

namespace Unit\Support\CurrentPlayer\Adapters;

use App\Support\CurrentPlayer\Adapters\SessionPlayer;
use Config;
use Database\Factories\PlayerFactory;
use Illuminate\Http\Request;
use Tests\TestCase;

class SessionPlayerTest extends TestCase {
    function test_it_retrieves_player_from_cookie() {
        $cookieName = 'cookieName';

        Config::set('game.current_player.cookie_name', $cookieName);
        $expectedPlayer = PlayerFactory::new()->create();
        $this->spy(Request::class)->shouldReceive('cookie')->with($cookieName)->andReturn($expectedPlayer->id);

        $sessionPlayer = $this->app->make(SessionPlayer::class);

        $actualPlayer = $sessionPlayer->retrieve();
        $this->assertEquals($expectedPlayer->id, $actualPlayer->id);
    }

    function test_it_queues_cookie_on_set() {
        $cookieName = 'cookieName';

        Config::set('game.current_player.cookie_name', $cookieName);
        $player = PlayerFactory::new()->create();
        $sessionPlayer = $this->app->make(SessionPlayer::class);
        $sessionPlayer->set($player);

        $this->get('/')->assertCookie($cookieName, $player->id);
    }
}

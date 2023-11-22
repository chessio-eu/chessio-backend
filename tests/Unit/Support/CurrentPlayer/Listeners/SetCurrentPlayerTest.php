<?php

namespace Tests\Unit\Support\CurrentPlayer\Listeners;

use App\Events\PlayerJoinedGame;

use App\Support\CurrentPlayer\CurrentPlayer;
use App\Support\CurrentPlayer\Listeners\SetCurrentPlayer;
use Database\Factories\PlayerFactory;
use Tests\TestCase;

class SetCurrentPlayerTest extends TestCase
{
    public function test_that_sets_http_player_when_player_joined_a_game() {
        $httpPlayerSpy = $this->spy(CurrentPlayer::class);

        $player = PlayerFactory::new()->create();
        $playerJoinedGame = new PlayerJoinedGame($player);
        $this->app->make(SetCurrentPlayer::class)->handle($playerJoinedGame);


        $httpPlayerSpy->shouldHaveReceived('set', [$player]);
    }
}

<?php

namespace Tests\Unit\Listeners;

use App\Enums\Color;
use App\Events\PlayerJoiningGame;
use App\Listeners\SetupPlayerColor;
use App\Models\Player;
use Event;
use Tests\TestCase;

class SetupPlayerColorTest extends TestCase
{
    public function test_player_has_the_expected_color()
    {
        Event::fake();

        $playerColorListener = $this->app->make(SetupPlayerColor::class);

        $player1 = Player::factory()->make(['color' => null]);
        $playerJoiningEvent = $this->app->make(PlayerJoiningGame::class, ['player' => $player1]);
        $playerColorListener->handle($playerJoiningEvent);
        $this->assertEquals(Color::White, $player1->color);
        $player1->save();

        $player2 = Player::factory()->for($player1->game)->make(['color' => null]);
        $playerJoiningEvent = $this->app->make(PlayerJoiningGame::class, ['player' => $player2]);
        $playerColorListener->handle($playerJoiningEvent);
        $this->assertEquals(Color::Black, $player2->color);
    }

    // test that second player has white color when first has black
}

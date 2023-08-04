<?php

namespace Tests\Unit\Models;

use App\Enums\Color;
use App\Events\GameStarted;
use App\Models\Player;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    public function test_fire_game_started_when_game_has_two_players()
    {
        Event::fake([
            GameStarted::class
        ]);

        $player1 = Player::factory()->create(['color' => Color::White]);
        $player2 = Player::factory()->for($player1->game)->create(['color' => Color::Black]);

        Event::assertDispatched(GameStarted::class);
    }
}

<?php

namespace Tests\Unit\Models;

use App\Enums\Color;
use App\Events\GameStarted;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class GameTest extends TestCase
{
    private Game $game;

    protected function setUp(): void
    {
        parent::setUp();
        $this->game = Game::factory()->create();
    }

    public function test_game_pieces_position_on_new_game()
    {
        $whitePlayer = Player::factory()->for($this->game)->create(['color' => Color::White]);
        $blackPlayer = Player::factory()->for($this->game)->create(['color' => Color::Black]);
        // TODO the assertion $this->game->createPieces()
        $this->game->createPieces();


    }

    public function test_game_returns_player_turn()
    {
        // TODO
    }
}

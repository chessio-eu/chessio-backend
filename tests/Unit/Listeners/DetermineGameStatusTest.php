<?php

namespace Unit\Listeners;

use App\Events\GameTied;
use App\Events\KingIsChecked;
use App\Events\PlayerJoinedGame;
use App\Events\PlayerTurnEnds;
use App\Events\PlayerWins;
use App\Models\Bishop;
use App\Models\Game;
use App\Models\King;
use App\Models\Knight;
use App\Models\Queen;
use App\Models\Rook;
use Tests\TestCase;

class DetermineGameStatusTest extends TestCase
{
    private Game $game;

    protected function setUp(): void
    {
        parent::setUp();

        \Event::fake([PlayerJoinedGame::class]);
        $this->game = Game::factory()->hasPlayers(2)->create();
    }

    public function test_it_dispatches_king_is_checked_when_player_turn_ends()
    {
        \Event::fake([KingIsChecked::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 3, 'positionY' => 3]);
        Queen::factory()->for($this->game->black_player)->create(['positionX' => 5, 'positionY' => 5]);

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertDispatched(function (KingIsChecked $event) {
           return $event->king->id === King::wherePlayerId($this->game->white_player->id)->first()->id;
        });
    }

    public function test_it_dispatches_player_wins_when_king_is_checked_and_has_no_available_moves()
    {
        \Event::fake([PlayerWins::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 0, 'positionY' => 0]);

        Rook::factory()->for($this->game->black_player)->create(['positionX' => 1, 'positionY' => 4]);
        Queen::factory()->for($this->game->black_player)->create(['positionX' => 0, 'positionY' => 5]);

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertDispatched(function (PlayerWins $event) {
           return $event->player->id === $this->game->black_player->id;
        });
    }

    public function test_it_doesnt_dispatch_player_wins_when_king_is_checked_and_can_move()
    {
        \Event::fake([PlayerWins::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 0, 'positionY' => 0]);

        Queen::factory()->for($this->game->black_player)->create(['positionX' => 0, 'positionY' => 5]);

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertNotDispatched(PlayerWins::class);
    }

    public function test_it_doesnt_dispatch_player_wins_when_king_is_checked_and_a_friendly_piece_can_cover_him()
    {
        \Event::fake([PlayerWins::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 0, 'positionY' => 0]);
        Rook::factory()->for($this->game->white_player)->create(['positionX' => 5, 'positionY' => 2]);

        Rook::factory()->for($this->game->black_player)->create(['positionX' => 1, 'positionY' => 4]);
        Queen::factory()->for($this->game->black_player)->create(['positionX' => 0, 'positionY' => 5]);

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertNotDispatched(PlayerWins::class);
    }

    public function test_it_doesnt_dispatch_player_wins_when_king_is_checked_and_a_friendly_piece_can_kill_the_checking_piece()
    {
        \Event::fake([PlayerWins::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 0, 'positionY' => 0]);
        Bishop::factory()->for($this->game->white_player)->create(['positionX' => 2, 'positionY' => 7]);

        Rook::factory()->for($this->game->black_player)->create(['positionX' => 1, 'positionY' => 4]);
        Queen::factory()->for($this->game->black_player)->create(['positionX' => 0, 'positionY' => 5]);

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertNotDispatched(PlayerWins::class);
    }

    public function test_it_dispatches_player_wins_when_king_is_checked_by_2_pieces_and_has_no_available_moves()
    {
        \Event::fake([PlayerWins::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 0, 'positionY' => 0]);
        Bishop::factory()->for($this->game->white_player)->create(['positionX' => 2, 'positionY' => 7]); //can kill the queen
        Rook::factory()->for($this->game->white_player)->create(['positionX' => 6, 'positionY' => 1]); //can kill the knight

        $knight = Knight::factory()->for($this->game->black_player)->create(['positionX' => 0, 'positionY' => 2]);
        Rook::factory()->for($this->game->black_player)->create(['positionX' => 1, 'positionY' => 4]);
        Queen::factory()->for($this->game->black_player)->create(['positionX' => 0, 'positionY' => 5]);
        $knight->move(2, 1);

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertDispatched(function (PlayerWins $event) {
            return $event->player->id === $this->game->black_player->id;
        });
    }

    public function test_it_dispatches_game_is_tied() {
        \Event::fake([GameTied::class]);

        King::factory()->for($this->game->white_player)->create(['positionX' => 0, 'positionY' => 0]);

        Rook::factory()->for($this->game->black_player)->create(['positionX' => 7, 'positionY' => 1]);
        Rook::factory()->for($this->game->black_player)->create(['positionX' => 1, 'positionY' => 5]);;

        PlayerTurnEnds::dispatch($this->game->black_player);

        \Event::assertDispatched(function (GameTied $event) {
            return $event->game->id === $this->game->id;
        });
    }
}

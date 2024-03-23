<?php

namespace Tests\Unit\Http\Requests;

use App\Models\Bishop;
use App\Models\Game;
use App\Models\Player;
use App\Support\CurrentPlayer\CurrentPlayer;
use Database\Factories\PlayerFactory;
use Tests\TestCase;

class MovePieceRequestTest extends TestCase
{
    protected $game;
    private function createGame()
    {
        $game = Game::factory()->create();
        Player::factory()->for($game)->create();
        Player::factory()->for($game)->create();

        return $game;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->game = $this->createGame();

        $this->whitePiece = Bishop::factory()->for($this->game->whitePlayer)->createOne([
            'positionX' => 4,
            'positionY' => 5,
        ]);
    }

    /** @test */
    public function test_it_fails_with_an_invalid_move()
    {
        $this->blackPiece = Bishop::factory()->for($this->game->blackPlayer)->createOne([
            'positionX' => 1,
            'positionY' => 1,
        ]);

        $data = [
            'positionX' => 7,
            'positionY' => 1,
        ];

        app(CurrentPlayer::class)->set($this->whitePiece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->whitePiece->id]), $data);

        $this->assertEquals($response->json('message'), 'Invalid move');
    }

    public function test_it_passes_with_a_valid_move()
    {
        $this->blackPiece = Bishop::factory()->for($this->game->blackPlayer)->createOne([
            'positionX' => 1,
            'positionY' => 1,
        ]);

        $data = [
            'positionX' => 7,
            'positionY' => 2,
        ];

        app(CurrentPlayer::class)->set($this->whitePiece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->whitePiece->id]), $data);

        $response->assertOk();
    }

    public function test_it_is_player_s_turn()
    {
        $this->blackPiece = Bishop::factory()->for($this->game->blackPlayer)->createOne([
            'positionX' => 1,
            'positionY' => 1,
        ]);

        $data = [
            'positionX' => 7,
            'positionY' => 2,
        ];

        app(CurrentPlayer::class)->set($this->whitePiece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->whitePiece->id]), $data);

        $response->assertOk();

        $data = [
            'positionX' => 3,
            'positionY' => 3,
        ];

        app(CurrentPlayer::class)->set($this->blackPiece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->blackPiece->id]), $data);

        $response->assertOk();
    }

    public function test_it_is_not_player_s_turn()
    {
        $data = [
            'positionX' => 1,
            'positionY' => 2,
        ];

        app(CurrentPlayer::class)->set($this->whitePiece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->whitePiece->id]), $data);

        $this->assertEquals($response->json('message'), 'Not player s turn');
    }
}

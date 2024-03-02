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

        $game = $this->createGame();


        $this->piece = Bishop::factory()->for($game->whitePlayer)->createOne([
            'positionX' => 4,
            'positionY' => 5,
        ]);
    }

    /** @test */
    public function test_it_fails_with_an_invalid_move()
    {
        $data = [
            'positionX' => 7,
            'positionY' => 1,
        ];

        app(CurrentPlayer::class)->set($this->piece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->piece->id]), $data);

        $this->assertEquals($response->json('message'), 'Invalid move');
    }

    public function test_it_passes_with_a_valid_move()
    {
        $data = [
            'positionX' => 7,
            'positionY' => 2,
        ];

        app(CurrentPlayer::class)->set($this->piece->player);

        $response = $this->json('POST',route('movePiece', ['piece' => $this->piece->id]), $data);

        $response->assertOk();
    }
}

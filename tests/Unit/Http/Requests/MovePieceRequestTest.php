<?php

namespace Tests\Unit\Http\Requests;

use App\Models\Bishop;
use App\Support\CurrentPlayer\CurrentPlayer;
use Tests\TestCase;

class MovePieceRequestTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        $this->piece = Bishop::factory()->createOne([
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

<?php

namespace Tests\Unit\Support\CurrentPlayer\Services;


use App\Support\CurrentPlayer\Contracts\PlayerAdapter;
use App\Support\CurrentPlayer\CurrentPlayer;
use Database\Factories\PlayerFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;
use Event;

class CurrentPlayerTest extends TestCase
{
    #[DataProvider('playerProvider')]
    function test_it_sets_current_player_with_player_adapter(\Closure $playerClosure) {
        $player = $playerClosure();
        $this->spy(PlayerAdapter::class)->shouldReceive('retrieve')->andReturn($player);

        $currentPlayer = $this->app->make(CurrentPlayer::class);
        $this->assertSame($player, $currentPlayer->get());
    }

    static function playerProvider(): array {
        return [
            [fn () => PlayerFactory::new()->create()],
            [fn () => null]
        ];
    }

    function test_it_calls_adapter_set() {
        Event::fake();
        $player = PlayerFactory::new()->create();
        $playerAdapterSpy = $this->spy(PlayerAdapter::class);

        $currentPlayer = $this->app->make(CurrentPlayer::class);
        $currentPlayer->set($player);

        $playerAdapterSpy->shouldHaveReceived('set', [$player]);
    }
}

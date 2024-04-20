<?php

namespace App\Support\CurrentPlayer\Adapters;

use App\Models\Player;
use App\Support\CurrentPlayer\Contracts\PlayerAdapter;
use Cookie;
use Illuminate\Http\Request;

class CookiePlayer implements PlayerAdapter {
    private string $cookieName;
    private Request $request;

    public function __construct(Request $request) {
        $this->cookieName = config('game.current_player.cookie_name', 'player_id');
        $this->request = $request;
    }

    public function retrieve(): Player|null
    {
        $player = null;
        $player_id = $this->request->cookie($this->cookieName);
        if ($player_id) {
            $player = Player::findOrFail($player_id);
        }
        return $player;
    }

    public function set(Player $player): void
    {
        Cookie::queue(Cookie::forever($this->cookieName, $player->id));
    }
}

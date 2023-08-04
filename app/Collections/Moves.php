<?php

namespace App\Collections;

use Illuminate\Support\Collection;

class Moves {
    private Collection $moves;

    function __construct() {
        $this->moves = new Collection();
    }

    function add($positionX, $positionY) {
        $this->moves->add([
            $positionX,
            $positionY
        ]);
    }

    function filter(?callable $callback = null) {
        return $this->moves->filter($callback);
    }

    function toArray() {
        return $this->moves->toArray();
    }
}
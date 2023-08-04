<?php

namespace App\Collections;

use Illuminate\Database\Eloquent\Collection;

class Pieces {
    private Collection $pieces;

    function __construct(Collection $pieces) {
        $this->pieces = $pieces;
    }

    
}
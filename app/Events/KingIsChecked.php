<?php

namespace App\Events;

use App\Models\King;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KingIsChecked
{
    use Dispatchable, SerializesModels;

    public function __construct(public King $king)
    {
    }
}

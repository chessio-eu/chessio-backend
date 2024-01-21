<?php

namespace App\Events;

use App\Models\King;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class KingIsThreatened
{
    use Dispatchable, SerializesModels;

    public function __construct(public King $king)
    {
    }
}

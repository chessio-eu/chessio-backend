<?php

namespace App\Enums;

enum GameStatus: string {
    case Pending = 'pending';
    case InProgress = 'in-progress';
    case Finished = 'finished';
};
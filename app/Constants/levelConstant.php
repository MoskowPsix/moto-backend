<?php

namespace App\Constants;

use App\Constants\Constants;

class levelConstant extends Constants
{
    public const EASY   = [
        'name'  => 'Низкая',
        'color' => '#22CA3D', // Green
    ];

    public const MEDIUM = [
        'name'  => 'Средняя',
        'color' => '#EF7C08', // Orange
    ];

    public const HARD   = [
        'name'  => 'Высокая',
        'color' => '#FD1215', // Red
    ];
}

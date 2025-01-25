<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentRaceCount extends Model
{
    protected $fillable = [
        'count',
        'race_id',
    ];
}

<?php

namespace App\Traits\Models;

use App\Models\AppointmentRaceCount;
use App\Models\Race;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait AppointmentRaceTrait
{
    public static function boot()
    {
        parent::boot();

        // beforeCreate
        self::created(function($model) {
            $race = $model->race()->first();
            $appointmentCount = $race->appointmentCount();
            if ($appointmentCount->exists()) {
                $appointmentCount->increment('count');
            } else {
                AppointmentRaceCount::create([
                    'race_id' => $race->id,
                    'count' => 1,
                ]);
            }
            return true;
        });
        self::deleted(function($model) {
            $race = $model->race()->first();
            $appointmentCount = $race->appointmentCount();
            if ($appointmentCount->exists()) {
                $count = $appointmentCount->first()->count - 1;
                $appointmentCount->update([
                    'count' => $count,
                ]);
            }
            return true;
        });
    }

    public function race(): BelongsTo
    {
        return $this->belongsTo(Race::class);
    }
}

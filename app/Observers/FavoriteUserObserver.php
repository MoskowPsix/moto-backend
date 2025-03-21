<?php

namespace App\Observers;

use App\Models\FavoriteCount;
use App\Models\FavoriteUser;
use Log;

class FavoriteUserObserver
{
    /**
     * Handle the FavoriteUser "created" event.
     */
    public function created(FavoriteUser $favoriteUser): void
    {
        $race = $favoriteUser->race()->first();
        $favoriteCount = $race->favoritesCount();
        if ($favoriteCount->exists()) {
            $favoriteCount->increment('count');
        } else {
            FavoriteCount::create([
                'race_id' => $race->id,
                'count' => 1,
            ]);
        }
    }

    /**
     * Handle the FavoriteUser "updated" event.
     */
    public function updated(FavoriteUser $favoriteUser): void
    {
        //
    }

    /**
     * Handle the FavoriteUser "deleted" event.
     */
    public function deleted(FavoriteUser $favoriteUser): void
    {
        $race = $favoriteUser->race()->first();
        $favoriteCount = $race->favoritesCount();
        if ($favoriteCount->exists()) {
            $count = $favoriteCount->first()->count - 1;
            $favoriteCount->update([
                'count' => $count,
            ]);
        }
    }

    /**
     * Handle the FavoriteUser "restored" event.
     */
    public function restored(FavoriteUser $favoriteUser): void
    {

    }

    /**
     * Handle the FavoriteUser "force deleted" event.
     */
    public function forceDeleted(FavoriteUser $favoriteUser): void
    {
    }
}

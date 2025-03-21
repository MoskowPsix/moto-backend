<?php

namespace App\Actions\Controllers\FavoriteUser;

use App\Contracts\Actions\Controllers\FavoriteUser\ToggleFavoriteRaceActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\FavoriteUser\Toggle\SuccessTogglrUserFavoriteResource;
use App\Models\FavoriteUser;
use App\Models\Race;

class ToggleFavoriteRaceAction implements ToggleFavoriteRaceActionContract
{
    public function __invoke(int $id): NotFoundResource|SuccessTogglrUserFavoriteResource
    {
        $user = auth()->user();
        $race = Race::find($id);
        if (!$race) {
            return NotFoundResource::make([]);
        }
        if (!FavoriteUser::where('user_id', $user->id)->where('race_id', $race->id)->exists()) {
             FavoriteUser::create([
                'user_id' => $user->id,
                'race_id' => $race->id,
            ]);
            $favorite = true;
        } else {
            FavoriteUser::where('user_id', $user->id)->where('race_id', $race->id)->first()->delete();
            $favorite = false;
        }
        return SuccessTogglrUserFavoriteResource::make($favorite);
    }
}

<?php

namespace App\Contracts\Actions\Controllers\FavoriteUser;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\FavoriteUser\Toggle\SuccessTogglrUserFavoriteResource;

interface ToggleFavoriteRaceActionContract
{
    public function __invoke(int $id): NotFoundResource|SuccessTogglrUserFavoriteResource;

}

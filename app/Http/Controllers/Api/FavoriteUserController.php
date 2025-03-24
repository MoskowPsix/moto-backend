<?php

namespace App\Http\Controllers\Api;

use App\Actions\Controllers\FavoriteUser\ToggleFavoriteRaceAction;
use App\Contracts\Actions\Controllers\FavoriteUser\ToggleFavoriteRaceActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\FavoriteUser\Toggle\SuccessTogglrUserFavoriteResource;
use App\Http\Resources\Grade\GetGrade\SuccessGetGradeResource;
use App\Models\Grade;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'FavoriteUser', description: 'Методы связанные с избранными гонками.')]
class FavoriteUserController extends Controller
{
    #[ResponseFromApiResource(SuccessTogglrUserFavoriteResource::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Authenticated]
    #[Endpoint(title: 'toggleFavoriteRace', description: 'Добавить или убрать гонку из избранного.')]
    public function toggleFavoriteRace(int $id, ToggleFavoriteRaceActionContract $action): NotFoundResource|SuccessTogglrUserFavoriteResource
    {
        return $action($id);
    }
}

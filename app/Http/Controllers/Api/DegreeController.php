<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Degree\GetDegreeActionContract;
use App\Contracts\Actions\Controllers\Degree\GetForIdsDegreeActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\Cup\GetForRaceId\SuccessGetForRaceIdCupResource;
use App\Http\Resources\Degree\Get\SuccessGetDegreeResource;
use App\Http\Resources\Degree\GetForIds\SuccessGetForIdsDegreeResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Cup;
use App\Models\Degree;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Degree', description: 'Методы связанные с уровнями кубков. Например всероссийский, областной и т.д.')]
class DegreeController extends Controller
{
    #[ResponseFromApiResource(SuccessGetDegreeResource::class, Degree::class, collection:true)]
    #[Endpoint(title: 'get', description: 'Получить все уровни.')]
    public function get(GetDegreeActionContract $action): SuccessGetDegreeResource
    {
        return $action();
    }
    #[ResponseFromApiResource(SuccessGetForIdsDegreeResource::class, Degree::class, collection:false)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'getForRaceId', description: 'Получение уровня по id.')]
    public function getForId(int $id, GetForIdsDegreeActionContract $action):
    NotFoundResource|
    SuccessGetForIdsDegreeResource
    {
        return $action($id);
    }
}

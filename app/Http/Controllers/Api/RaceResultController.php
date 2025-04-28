<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\RaceResult\GetResultsActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\RaceResult\GetRaceResultsRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\RaceResult\Get\SuccessGetRaceResultsResource;
use App\Models\RaceResult;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'RaceResult', description: 'Управление результатами гонок.')]
class RaceResultController extends Controller
{
    #[ResponseFromApiResource(SuccessGetRaceResultsResource::class, RaceResult::class, collection: true)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'get', description: 'Получение результатов гонки по фильтрам.')]
    public function get($id, GetRaceResultsRequest $request, GetResultsActionContract $action):SuccessGetRaceResultsResource|
    NotFoundResource
    {
        return $action($id, $request);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Location\GetLocationActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Location\GetLocationRequest;
use App\Http\Resources\Location\LocationResource\SuccessGetLocationResource;
use App\Models\Location;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Location', description: 'Методы для взаимодействия с городами')]
class LocationController extends Controller
{
    #[ResponseFromApiResource(SuccessGetLocationResource::class, Location::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение всех городов с фильтрацией')]
    public function get(GetLocationRequest $request, GetLocationActionContract $action): SuccessGetLocationResource
    {
        return $action($request);
    }
}

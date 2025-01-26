<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Race\CreateRaceActionContract;
use App\Contracts\Actions\Race\GetForIdRaceActionContract;
use App\Contracts\Actions\Race\GetRaceActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Race\CreateRaceRequest;
use App\Http\Requests\Race\GetForIdRaceRequest;
use App\Http\Requests\Race\GetRaceRequest;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Http\Resources\Race\Create\SuccessCreateRaceResource;
use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;
use App\Http\Resources\Race\GetRaces\SuccessGetRaceResource;
use App\Models\Race;
use App\Models\User;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Race', description: 'Методы связанные с гонками')]
class RaceController extends Controller
{
    #[ResponseFromApiResource(SuccessGetRaceResource::class, Race::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение всех гонок по фильтрам')]
    public function get(GetRaceRequest $request, GetRaceActionContract $action): SuccessGetRaceResource
    {
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessGetRaceForIdResource::class, Race::class, collection: false)]
    #[Endpoint(title: 'getForId', description: 'Получение гонки по id')]
    public function getForId(int $id, GetForIdRaceRequest $request, GetForIdRaceActionContract $action): SuccessGetRaceForIdResource
    {
        return $action($id, $request);
    }
    #[ResponseFromApiResource(SuccessCreateRaceResource::class, Race::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание гонки')]
    public function create(CreateRaceRequest $request, CreateRaceActionContract $action): SuccessCreateRaceResource
    {
        return $action($request);
    }
//    public function update()
//    {}
//    public function delete()
//    {}
}

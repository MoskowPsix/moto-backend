<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Cup\CreateCupActionContract;
use App\Contracts\Actions\Controllers\Cup\GetForIdCupActionContract;
use App\Contracts\Actions\Controllers\Cup\GetForRaceIdCupActionContract;
use App\Contracts\Actions\Controllers\Cup\UpdateCupActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cup\CreateCupRequest;
use App\Http\Requests\Cup\GetForIdCupRequest;
use App\Http\Requests\Cup\GetForRaceIdCupRequest;
use App\Http\Requests\Cup\UpdateCupRequest;
use App\Http\Resources\Cup\Create\SuccessCreateCupResource;
use App\Http\Resources\Cup\GetForId\SuccessGetForIdCupResource;
use App\Http\Resources\Cup\GetForRaceId\SuccessGetForRaceIdCupResource;
use App\Http\Resources\Cup\Update\SuccessUpdateCupResource;
use App\Models\Cup;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Cup', description: 'Методы связанные с кубками')]
class CupController extends Controller
{
    #[ResponseFromApiResource(SuccessGetForRaceIdCupResource::class, Cup::class, collection:false)]
    #[Endpoint(title: 'getForRaceId', description: 'Получение кубков по id гонки')]
    public function getForRaceId(int $id, GetForRaceIdCupRequest $request, GetForRaceIdCupActionContract $action): SuccessGetForRaceIdCupResource
    {
        return $action($id, $request);
    }

    #[ResponseFromApiResource(SuccessGetForIdCupResource::class, Cup::class, collection:false)]
    #[Endpoint(title: 'getForId', description: 'Получение кубков по id')]
    public function getForId(int $id, GetForIdCupRequest $request, GetForIdCupActionContract $action): SuccessGetForIdCupResource
    {
        return $action($id, $request);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateCupResource::class, Cup::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание кубка')]
    public function create(CreateCupRequest $request, CreateCupActionContract $action): SuccessCreateCupResource
    {
        return $action($request);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessUpdateCupResource::class, Cup::class, collection: false)]
    #[Endpoint(title: 'update', description: 'Обновление кубка')]
    public function update(int $id, UpdateCupRequest $request, UpdateCupActionContract $action): SuccessUpdateCupResource
    {
        return $action($id, $request);
    }
}

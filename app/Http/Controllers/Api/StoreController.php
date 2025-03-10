<?php

namespace App\Http\Controllers\Api;
use App\Contracts\Actions\Controllers\Store\CreateStoreActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Resources\Store\Create\SuccessCreateStoreResource;
use App\Models\Store;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Store', description: 'Методы связанные с магазинами')]
class StoreController extends Controller
{
    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateStoreResource::class, Store::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание магазина')]
    public function create(CreateStoreRequest $request, CreateStoreActionContract $action): SuccessCreateStoreResource
    {
        return $action($request);
    }
}

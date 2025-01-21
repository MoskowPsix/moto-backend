<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\PersonalInfo\CreatePersonalInfoActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalInfo\CreatePersonalInfoRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\PersonalInfo\Create\SuccessCreatePersonalInfoResource;
use App\Models\PersonalInfo;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'PersonalInfo', description: 'Всё что связанно с персональной информацией пользователя')]
class PersonalInfoController extends Controller
{
    #[Endpoint(title: 'Create', description: 'Создать запись персональных данных')]
    #[ResponseFromApiResource(SuccessCreatePersonalInfoResource::class, PersonalInfo::class, collection: false)]
    public function create(CreatePersonalInfoRequest $request, CreatePersonalInfoActionContract $action): SuccessCreatePersonalInfoResource
    {
        return $action($request);
    }
}

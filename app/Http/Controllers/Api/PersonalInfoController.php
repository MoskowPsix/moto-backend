<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\PersonalInfo\CreatePersonalInfoActionContract;
use App\Contracts\Actions\PersonalInfo\UpdatePersonalInfoActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\PersonalInfo\CreatePersonalInfoRequest;
use App\Http\Requests\PersonalInfo\UpdatePersonalInfoRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\PersonalInfo\Create\SuccessCreatePersonalInfoResource;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoResource;
use App\Models\PersonalInfo;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'PersonalInfo', description: 'Всё что связанно с персональной информацией пользователя')]
class PersonalInfoController extends Controller
{
    #[Authenticated]
    #[Endpoint(title: 'Create', description: 'Создать запись персональных данных')]
    #[ResponseFromApiResource(SuccessCreatePersonalInfoResource::class, PersonalInfo::class, collection: false)]
    public function create(CreatePersonalInfoRequest $request, CreatePersonalInfoActionContract $action): SuccessCreatePersonalInfoResource
    {
        return $action($request);
    }
    #[Authenticated]
    #[Endpoint(title: 'Update', description: 'Обновить запись персональных данных')]
    #[ResponseFromApiResource(SuccessUpdatePersonalInfoResource::class, PersonalInfo::class, collection: false)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[ResponseFromApiResource(NotFoundResource::class, PersonalInfo::class, status: 404)]
    public function update(UpdatePersonalInfoRequest $request, UpdatePersonalInfoActionContract $action): SuccessUpdatePersonalInfoResource | NotFoundResource | NotUserPermissionResource
    {
        return $action($request);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Role\AddCommissionUserActionContract;
use App\Contracts\Actions\Controllers\Role\ChangeRoleForDefaultUserActionContract;
use App\Contracts\Actions\Controllers\Role\GetChangeRolesActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\NoRoleChangeRoleForDefaultUserResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Http\Resources\Role\GetChangeRole\SuccessGetChangeRoleResource;
use App\Models\User;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Spatie\Permission\Models\Role;

#[Group(name: 'Role', description: 'Методы взаимодествия с ролями')]
class RoleController extends Controller
{
    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetChangeRoleResource::class, Role::class, collection: true)]
    #[Endpoint(title: 'GetChangeRoles', description: 'Получение ролей которые может сменить обычный пользователь')]
    public function getChangeRoles(GetChangeRolesActionContract $actionRole): SuccessGetChangeRoleResource
    {
        return $actionRole();
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessChangeRoleForDefaultUserResource::class, User::class, collection: false)]
    #[Endpoint(title: 'ChangeRoleForDefaultUser', description: 'Сменить роль для обычного пользователя')]
    public function changeRoleForDefaultUser(ChangeRoleForDefaultUserRequest $request, ChangeRoleForDefaultUserActionContract $action):SuccessChangeRoleForDefaultUserResource | NoRoleChangeRoleForDefaultUserResource
    {
        return $action($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(SuccessChangeRoleForDefaultUserResource::class)]
    #[Endpoint(title: 'addCommission', description: 'Дать роль судьи пользователю, доступно только комиссии')]
    public function addCommission(int $id, AddCommissionUserActionContract $action): NotFoundResource|SuccessChangeRoleForDefaultUserResource
    {
        return $action($id);
    }
}

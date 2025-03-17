<?php

namespace App\Http\Controllers\Api;

use App\Actions\Controllers\User\GetUserForTokenAction;
use App\Contracts\Actions\Controllers\User\DeleteUserActionContract;
use App\Contracts\Actions\Controllers\User\GetCommisionUserActionContract;
use App\Contracts\Actions\Controllers\User\GetUserForIdActionContract;
use App\Contracts\Actions\Controllers\User\UpdateUserActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\User\GetCommisionUserRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\User\Delete\SuccessUserDeleteResource;
use App\Http\Resources\User\GetCommision\SuccessGetCommisionUserResource;
use App\Http\Resources\User\GetForId\SuccessUserGetForIdResource;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
use App\Http\Resources\User\Update\ErrorUpdateUserResource;
use App\Http\Resources\User\Update\SuccessUpdateUserResource;
use App\Models\User;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'User', description: 'Методы манипуляции пользователем.')]
class UserController extends Controller
{
    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetUserForTokenResource::class, User::class, collection: false)]
    #[Endpoint(title: 'GetUserForToken', description: 'Получить данные пользователя по токену')]
    public function getUserForToken(GetUserForTokenAction $actionGetUser): SuccessGetUserForTokenResource
    {
        return $actionGetUser();
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessUpdateUserResource::class, User::class, collection: false)]
    #[ResponseFromApiResource(ErrorUpdateUserResource::class, status: 500)]
    #[Endpoint(title: 'update', description: 'Обновить профиль пользователя')]
    public function update(UpdateUserRequest $request, UpdateUserActionContract $action ): SuccessUpdateUserResource | ErrorUpdateUserResource
    {
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessUserGetForIdResource::class, User::class, collection: false)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'getForId', description: 'Получить пользователя по id')]
    public function getForId(int $id, GetUserForIdActionContract $action): SuccessUserGetForIdResource | NotFoundResource
    {
        return $action($id);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetCommisionUserResource::class, User::class, collection: true)]
    #[Endpoint(title: 'getCommissions', description: 'Получить список судей')]
    public function getCommissions(GetCommisionUserRequest $request, GetCommisionUserActionContract $action): SuccessGetCommisionUserResource
    {
        return $action($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessUserDeleteResource::class)]
    #[Endpoint(title: 'Delete', description: 'Удаление аккаунта пользователя')]
    public function delete(DeleteUserActionContract $action): SuccessUserDeleteResource
    {
        return $action();
    }
}

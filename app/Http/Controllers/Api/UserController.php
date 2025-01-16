<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\GetUserForTokenAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
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
}

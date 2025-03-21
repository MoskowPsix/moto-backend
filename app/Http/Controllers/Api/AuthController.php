<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Auth\LoginActionContract;
use App\Contracts\Actions\Controllers\Auth\LogoutActionContract;
use App\Contracts\Actions\Controllers\Auth\RegisterActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\FailedLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Http\Resources\Error\Login\ErrorEmailExistsResource;
use App\Models\User;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Auth', description: 'Авторизация пользователей и всё что с ней связано.')]
class AuthController extends Controller
{
    #[ResponseFromApiResource(SuccessRegisterResource::class, User::class, collection: false)]
    #[ResponseFromApiResource(ErrorRegisterResource::class, null, 403)]
    #[ResponseFromApiResource(ErrorEmailExistsResource::class, status: 422)]
    #[Endpoint(title: 'Register', description: 'Регистрация нового пользователя')]
    public function register(RegisterRequest $request, RegisterActionContract $registerAction): SuccessRegisterResource|ErrorRegisterResource|ErrorEmailExistsResource
    {
        return $registerAction($request);
    }
    #[ResponseFromApiResource(ErrorLoginResource::class, null, 403)]
    #[ResponseFromApiResource(SuccessLoginResource::class, User::class, collection: false)]
    #[Endpoint(title: 'Login', description: 'Авторизация пользователя')]
    public function login(LoginRequest $request, LoginActionContract $loginAction): SuccessLoginResource | ErrorLoginResource
    {
        return $loginAction($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessLogoutResource::class, User::class, collection: false)]
    #[ResponseFromApiResource(ErrorLogoutResource::class, null, 500)]
    #[Endpoint(title: 'logout', description: 'Выход пользователя')]
    public function logout(LogoutActionContract $logoutAction): SuccessLogoutResource | ErrorLogoutResource
    {
        return $logoutAction();
    }
}

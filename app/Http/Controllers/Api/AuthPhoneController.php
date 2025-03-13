<?php

namespace App\Http\Controllers\Api;

use App\Actions\Controllers\AuthPhone\RegisterPhoneAction;
use App\Contracts\Actions\Controllers\AuthPhoneController\HookPhoneVerifyActionContract;
use App\Contracts\Actions\Controllers\AuthPhoneController\LoginPhoneActionContract;
use App\Contracts\Actions\Controllers\AuthPhoneController\RegisterPhoneActionContract;
use App\Contracts\Actions\Controllers\AuthPhoneController\VerifyPhoneActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthPhone\HookPhoneVerifyRequest;
use App\Http\Requests\AuthPhone\LoginRequest;
use App\Http\Requests\AuthPhone\RegisterRequest;
use App\Http\Requests\AuthPhone\VerifyPhoneRequest;
use App\Http\Resources\AuthPhone\Login\SuccessLoginPhoneResource;
use App\Http\Resources\AuthPhone\Login\SuccessLoginResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Errors\TimeOutWarningResource;
use App\Models\User;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'AuthPhone', description: 'Авторизация пользователей через телефон.')]
class AuthPhoneController extends Controller
{
    #[ResponseFromApiResource(SuccessLoginPhoneResource::class)]
    #[Endpoint(title: 'Login', description: 'Вход пользователя через телефон.')]
    public function login(LoginRequest $request, LoginPhoneActionContract $action):  SuccessLoginPhoneResource|TimeOutWarningResource
    {
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessLoginPhoneResource::class)]
    #[Endpoint(title: 'Register', description: 'Регистрация нового пользователя через телефон.')]
    public function register(RegisterRequest $request, RegisterPhoneActionContract $action):  SuccessLoginPhoneResource
    {
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessLoginResource::class, User::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'Verify', description: 'Подтверждение телефона и вход пользователя.')]
    public function verify(VerifyPhoneRequest $request, VerifyPhoneActionContract $action):
    SuccessLoginResource|
    NotFoundResource|
    NotUserPermissionResource
    {
        return $action($request);
    }
    public function hook(HookPhoneVerifyRequest $request, HookPhoneVerifyActionContract $action): void
    {
        $action($request);
    }
}

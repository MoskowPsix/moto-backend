<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\RecoveryPassword\RecoveryRecoveryPasswordActionContract;
use App\Contracts\Actions\Controllers\RecoveryPassword\SendRecoveryPasswordActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\RecoveryPassword\RecoveryRequest;
use App\Http\Requests\RecoveryPassword\SendRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\RecoveryPassword\Recovery\SuccessRecoveryRecoveryPasswordResource;
use App\Http\Resources\RecoveryPassword\Send\SuccessSendRecoveryPasswordResource;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'RecoveryPassword', description: 'Методы связанные с восстановлением пароля')]

class RecoveryPassword extends Controller
{
    #[ResponseFromApiResource(SuccessSendRecoveryPasswordResource::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'send', description: 'Отправка токена восстановления на почту')]
    public function send(SendRequest $request, SendRecoveryPasswordActionContract $action):
    SuccessSendRecoveryPasswordResource|
    NotFoundResource
    {
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessRecoveryRecoveryPasswordResource::class)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'recovery', description: 'Смена пароля с токена из почты')]
    public function recovery(RecoveryRequest $request, RecoveryRecoveryPasswordActionContract $action):
    NotUserPermissionResource|
    SuccessRecoveryRecoveryPasswordResource
    {
        return $action($request);
    }
}

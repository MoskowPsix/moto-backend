<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\VerificationEmail\SendActionContract;
use App\Contracts\Actions\VerificationEmail\VerificationActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;

#[Group(name: 'VerificationEmail', description: 'Подтверждение почты через письмо')]
class VerificationEmail extends Controller
{
    #[Authenticated]
    #[Endpoint(title: 'send', description: 'Отправка письма на почту пользователя')]

    public function send(SendActionContract $action): AlreadySendVerificationEmailResource | SuccessSendVerificationEmailResource
    {
        return $action();
    }
    #[Authenticated]
    #[Endpoint(title: 'verify', description: 'Подтверждение почты пользователя по коду из письма')]
    public function verify(EmailVerificationRequest $request, VerificationActionContract $actionContract)
    {
        return $actionContract($request);
    }
}

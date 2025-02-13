<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\VerificationEmail\SendActionContract;
use App\Contracts\Actions\Controllers\VerificationEmail\VerificationActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Resources\Errors\TimeOutWarningResource;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\NoCorrectVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\SuccessVerificationEmailResource;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'VerificationEmail', description: 'Подтверждение почты через письмо')]
class VerificationEmail extends Controller
{
    #[Authenticated]
    #[ResponseFromApiResource(SuccessSendVerificationEmailResource::class)]
    #[ResponseFromApiResource(AlreadySendVerificationEmailResource::class, status: 403)]
    #[Endpoint(title: 'send', description: 'Отправка письма на почту пользователя')]
    public function send(SendActionContract $action): AlreadySendVerificationEmailResource|SuccessSendVerificationEmailResource|TimeOutWarningResource
    {
        return $action();
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessVerificationEmailResource::class)]
    #[ResponseFromApiResource(AlreadySendVerificationEmailResource::class, status: 403)]
    #[ResponseFromApiResource(NoCorrectVerificationEmailResource::class, status: 403)]
    #[Endpoint(title: 'verify', description: 'Подтверждение почты пользователя по коду из письма')]
    public function verify(EmailVerificationRequest $request, VerificationActionContract $actionContract): AlreadySendVerificationEmailResource|NoCorrectVerificationEmailResource|SuccessVerificationEmailResource
    {
        return $actionContract($request);
    }
}

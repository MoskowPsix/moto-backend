<?php

namespace App\Actions\VerificationEmail;

use App\Contracts\Actions\VerificationEmail\SendActionContract;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;
use App\Notifications\VerificationEmailNotification;

class SendAction implements SendActionContract
{

    public function __invoke(): AlreadySendVerificationEmailResource | SuccessSendVerificationEmailResource
    {
        if (!empty(auth()->user()->email_verified_at)) {
            return AlreadySendVerificationEmailResource::make([]);
        }
        auth()->user()->notify(new VerificationEmailNotification());
        return SuccessSendVerificationEmailResource::make([]);
    }
}

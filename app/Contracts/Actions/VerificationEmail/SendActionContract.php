<?php

namespace App\Contracts\Actions\VerificationEmail;

use App\Http\Resources\Error\TimeOutWarningResource;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;

interface SendActionContract
{
    public function __invoke(): AlreadySendVerificationEmailResource|SuccessSendVerificationEmailResource|TimeOutWarningResource;
}

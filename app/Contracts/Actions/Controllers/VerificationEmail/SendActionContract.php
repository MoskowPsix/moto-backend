<?php

namespace App\Contracts\Actions\Controllers\VerificationEmail;

use App\Http\Resources\Errors\TimeOutWarningResource;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;

interface SendActionContract
{
    public function __invoke(): AlreadySendVerificationEmailResource|SuccessSendVerificationEmailResource|TimeOutWarningResource;
}

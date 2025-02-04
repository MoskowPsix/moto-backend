<?php

namespace App\Contracts\Actions\VerificationEmail;

use App\Http\Requests\EmailVerificationRequest;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\NoCorrectVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\SuccessVerificationEmailResource;

interface VerificationActionContract
{
    public function __invoke(EmailVerificationRequest $request): AlreadySendVerificationEmailResource|NoCorrectVerificationEmailResource|SuccessVerificationEmailResource;
}

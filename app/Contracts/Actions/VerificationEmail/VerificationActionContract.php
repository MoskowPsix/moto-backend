<?php

namespace App\Contracts\Actions\VerificationEmail;

use App\Http\Requests\EmailVerificationRequest;

interface VerificationActionContract
{
    public function __invoke(EmailVerificationRequest $request);
}

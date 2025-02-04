<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\VerificationEmail\SendActionContract;
use App\Contracts\Actions\VerificationEmail\VerificationActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;

class VerificationEmail extends Controller
{
    public function send(SendActionContract $action): AlreadySendVerificationEmailResource | SuccessSendVerificationEmailResource
    {
        return $action();
    }
    public function verify(EmailVerificationRequest $request, VerificationActionContract $actionContract)
    {
        return $actionContract($request);
    }
}

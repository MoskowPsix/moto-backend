<?php

namespace App\Actions\Controllers\VerificationEmail;

use App\Contracts\Actions\Controllers\VerificationEmail\SendActionContract;
use App\Http\Resources\Errors\TimeOutWarningResource;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Send\SuccessSendVerificationEmailResource;
use App\Notifications\VerificationEmailNotification;
use Carbon\Carbon;

class SendAction implements SendActionContract
{

    public function __invoke(): AlreadySendVerificationEmailResource|SuccessSendVerificationEmailResource|TimeOutWarningResource
    {
        $user = auth()->user();
        if (!empty($user->email_verified_at)) {
            return AlreadySendVerificationEmailResource::make([]);
        }
        $ecode = $user->ecode()->first();
        if (isset($ecode) && $ecode->created_at->addMinute() > Carbon::now()) {
            return TimeOutWarningResource::make(60 - $ecode->created_at->addMinute()->diff(Carbon::now())->format('%s'));
        }
        $user->notify(new VerificationEmailNotification());
        return SuccessSendVerificationEmailResource::make([]);
    }
}

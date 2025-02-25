<?php

namespace App\Actions\Controllers\RecoveryPassword;

use App\Contracts\Actions\Controllers\RecoveryPassword\SendRecoveryPasswordActionContract;
use App\Http\Requests\RecoveryPassword\SendRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\RecoveryPassword\Send\SuccessSendRecoveryPasswordResource;
use App\Models\User;
use App\Notifications\RecoveryPasswordNotify;
use Carbon\Carbon;

class SendRecoveryPasswordAction implements SendRecoveryPasswordActionContract
{
    public function __invoke(SendRequest $request): NotFoundResource | SuccessSendRecoveryPasswordResource
    {
        $user = User::where('email', $request->email)->whereNotNull('email_verified_at')->first();
        if (!isset($user)) {
            return NotFoundResource::make([]);
        }
        $token = $this->generateToken($user);
        $user->notify(new RecoveryPasswordNotify($request->url, $token));
        return SuccessSendRecoveryPasswordResource::make([]);
    }

    private function generateToken(User $user): string
    {
        return encrypt($user->id . ',' . $user->email . ',' . Carbon::now());
    }
}

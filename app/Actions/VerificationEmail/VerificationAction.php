<?php

namespace App\Actions\VerificationEmail;

use App\Contracts\Actions\VerificationEmail\VerificationActionContract;
use App\Http\Requests\EmailVerificationRequest;
use App\Http\Resources\verificationEmail\Send\AlreadySendVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\NoCorrectVerificationEmailResource;
use App\Http\Resources\verificationEmail\Verification\SuccessVerificationEmailResource;
use App\Models\User;
use Carbon\Carbon;

class VerificationAction implements VerificationActionContract
{

    public function __invoke(EmailVerificationRequest $request): AlreadySendVerificationEmailResource|NoCorrectVerificationEmailResource|SuccessVerificationEmailResource
    {
        $user = auth()->user();
        if (!empty($user->email_verified_at)) {
            return AlreadySendVerificationEmailResource::make([]);
        }
        if (!$user->ecode()->where('created_at', '>=' , Carbon::now()->subHour(1))->exists()) {
            return NoCorrectVerificationEmailResource::make([]);
        }
        $ecode = $user->ecode()->where('created_at', '>=' , Carbon::now()->subHour(1))->first();
        if ($ecode->code !== (int)$request->code) {
            return NoCorrectVerificationEmailResource::make([]);
        }
        User::where('id', $user->id)->update(['email_verified_at' => Carbon::now()]);
        $ecode->delete();
        return SuccessVerificationEmailResource::make([]);
    }
}

<?php

namespace App\Actions\Controllers\RecoveryPassword;

use App\Contracts\Actions\Controllers\RecoveryPassword\RecoveryRecoveryPasswordActionContract;
use App\Http\Requests\RecoveryPassword\RecoveryRequest;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\RecoveryPassword\Recovery\SuccessRecoveryRecoveryPasswordResource;
use App\Models\User;
use Carbon\Carbon;

class RecoveryRecoveryPasswordAction implements RecoveryRecoveryPasswordActionContract
{
    public function __invoke(RecoveryRequest $request): NotUserPermissionResource|SuccessRecoveryRecoveryPasswordResource
    {
        $token = $this->encryptToken($request->token);
        if (Carbon::parse($token[2])->addHour() < Carbon::now()){
            return NotUserPermissionResource::make([]);
        }
        User::where('id', $token[0])->update([
            'password' => bcrypt($request->password)
        ]);
        return SuccessRecoveryRecoveryPasswordResource::make([]);
    }
    private function encryptToken(string $token): array
    {
        return explode(',', decrypt($token));
    }
}

<?php

namespace App\Actions\Controllers\AuthPhoneController;

use App\Contracts\Actions\Controllers\AuthPhoneController\HookPhoneVerifyActionContract;
use App\Http\Requests\AuthPhone\HookPhoneVerifyRequest;

class HookPhoneVerifyAction implements HookPhoneVerifyActionContract
{

    public function __invoke(HookPhoneVerifyRequest $request): void
    {
        info($request->phone, $request->key);
    }
}

<?php

namespace App\Contracts\Actions\Controllers\AuthPhoneController;

use App\Http\Requests\AuthPhone\HookPhoneVerifyRequest;

interface HookPhoneVerifyActionContract
{
    public function __invoke(HookPhoneVerifyRequest $request);
}

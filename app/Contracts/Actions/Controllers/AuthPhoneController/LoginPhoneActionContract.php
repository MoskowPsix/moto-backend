<?php

namespace App\Contracts\Actions\Controllers\AuthPhoneController;

use App\Http\Requests\AuthPhone\LoginRequest;
use App\Http\Resources\AuthPhone\Login\SuccessLoginPhoneResource;
use App\Http\Resources\Errors\TimeOutWarningResource;

interface LoginPhoneActionContract
{
    public function __invoke(LoginRequest $request):SuccessLoginPhoneResource|TimeOutWarningResource;
}

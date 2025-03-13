<?php

namespace App\Contracts\Actions\Controllers\AuthPhoneController;

use App\Http\Requests\AuthPhone\LoginRequest;

interface LoginPhoneActionContract
{
    public function __invoke(LoginRequest $request);
}

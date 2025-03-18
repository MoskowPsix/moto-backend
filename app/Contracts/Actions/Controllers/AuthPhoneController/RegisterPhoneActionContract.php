<?php

namespace App\Contracts\Actions\Controllers\AuthPhoneController;

use App\Http\Requests\AuthPhone\RegisterRequest;

interface RegisterPhoneActionContract
{
    public function __invoke(RegisterRequest $request);
}

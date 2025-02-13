<?php

namespace App\Contracts\Actions\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;

interface RegisterActionContract
{
    public function __invoke(RegisterRequest $request): ErrorRegisterResource | SuccessRegisterResource;
}

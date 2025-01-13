<?php

namespace App\Contracts\Actions\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\Register\ErrorRegisterResource;
use App\Http\Resources\Auth\Register\SuccessRegisterResource;
use App\Models\User;

interface RegisterActionContract
{
    public function __invoke(RegisterRequest $request): ErrorRegisterResource | SuccessRegisterResource;
}

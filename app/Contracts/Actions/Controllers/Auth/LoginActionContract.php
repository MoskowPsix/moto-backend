<?php

namespace App\Contracts\Actions\Controllers\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\Login\ErrorLoginResource;
use App\Http\Resources\Auth\Login\SuccessLoginResource;

interface LoginActionContract
{
 public function __invoke(LoginRequest $request): SuccessLoginResource | ErrorLoginResource;
}

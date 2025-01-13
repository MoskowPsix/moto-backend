<?php

namespace App\Contracts\Actions\Auth;

use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;

interface LogoutActionContract
{
    public function __invoke(): SuccessLogoutResource | ErrorLogoutResource;
}

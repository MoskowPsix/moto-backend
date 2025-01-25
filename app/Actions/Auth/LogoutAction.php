<?php

namespace App\Actions\Auth;

use App\Contracts\Actions\Auth\LogoutActionContract;
use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;

class LogoutAction implements LogoutActionContract
{
    public function __invoke(): SuccessLogoutResource | ErrorLogoutResource
    {
        if(auth()->check()) {
            auth()->user()->currentAccessToken()->delete();
            return SuccessLogoutResource::make([]);
        }
        else{
            return ErrorLogoutResource::make([]);
        }
    }
}

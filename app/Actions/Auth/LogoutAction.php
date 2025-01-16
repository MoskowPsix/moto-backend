<?php

namespace App\Actions\Auth;

use App\Contracts\Actions\Auth\LogoutActionContract;
use App\Http\Resources\Auth\Logout\ErrorLogoutResource;
use App\Http\Resources\Auth\Logout\SuccessLogoutResource;

class LogoutAction implements LogoutActionContract
{
    public function __invoke(): SuccessLogoutResource | ErrorLogoutResource
    {
//        try {
//            auth()->user()->currentAccessToken()->delete();
//            return SuccessLogoutResource::make([]);
//        } catch (\Exception $e) {
//            return ErrorLogoutResource::make([]);
//        }
        if(auth()->user() != null) {
            auth()->user()->currentAccessToken()->delete();
            return SuccessLogoutResource::make([]);
        }
        else{
            return ErrorLogoutResource::make([]);
        }
    }
}

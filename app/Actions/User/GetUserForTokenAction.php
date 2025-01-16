<?php

namespace App\Actions\User;

use App\Contracts\Actions\User\GetUserForTokenActionContract;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;

class GetUserForTokenAction implements GetUserForTokenActionContract
{
    public function __invoke(): SuccessGetUserForTokenResource
    {
        $user = auth()->user();
        return SuccessGetUserForTokenResource::make($user);
    }
}

<?php

namespace App\Actions\User;

use App\Contracts\Actions\User\GetUserForTokenActionContract;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
use App\Models\User;

class GetUserForTokenAction implements GetUserForTokenActionContract
{
    public function __invoke(): SuccessGetUserForTokenResource
    {
        $user = User::with('roles', 'personalInfo')->where('id', auth()->user()->id)->first();
        return SuccessGetUserForTokenResource::make($user);
    }
}

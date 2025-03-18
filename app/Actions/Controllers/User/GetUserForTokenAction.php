<?php

namespace App\Actions\Controllers\User;

use App\Contracts\Actions\Controllers\User\GetUserForTokenActionContract;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
use App\Models\User;

class GetUserForTokenAction implements GetUserForTokenActionContract
{
    public function __invoke(): SuccessGetUserForTokenResource
    {
        $user = User::with('roles', 'personalInfo.location', 'personalInfo.command', 'phone')->where('id', auth()->user()->id)->first();
        return SuccessGetUserForTokenResource::make($user);
    }
}

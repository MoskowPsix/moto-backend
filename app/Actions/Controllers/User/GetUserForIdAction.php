<?php

namespace App\Actions\Controllers\User;

use App\Contracts\Actions\Controllers\User\GetUserForIdActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\User\GetForId\SuccessUserGetForIdResource;
use App\Models\User;

class GetUserForIdAction implements GetUserForIdActionContract
{

    public function __invoke(int $id): SuccessUserGetForIdResource | NotFoundResource
    {
        $user = User::with('personalInfo')->where('id', $id);
        if (!$user->exists())
        {
            return NotFoundResource::make([]);
        }
        return SuccessUserGetForIdResource::make($user->first());
    }
}

<?php

namespace App\Actions\Controllers\User;

use App\Contracts\Actions\Controllers\User\DeleteUserActionContract;
use App\Http\Resources\User\Delete\SuccessUserDeleteResource;

class DeleteUserAction implements DeleteUserActionContract
{
    public function __invoke(): SuccessUserDeleteResource
    {
        auth()->user()->forceDelete();
        return SuccessUserDeleteResource::make([]);
    }
}

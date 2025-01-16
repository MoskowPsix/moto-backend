<?php

namespace App\Contracts\Actions\User;

use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;

interface GetUserForTokenActionContract
{
    public function __invoke(): SuccessGetUserForTokenResource;
}

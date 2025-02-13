<?php

namespace App\Contracts\Actions\Controllers\User;

use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;

interface GetUserForTokenActionContract
{
    public function __invoke(): SuccessGetUserForTokenResource;
}

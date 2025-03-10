<?php

namespace App\Contracts\Actions\Controllers\User;

use App\Http\Requests\User\GetCommisionUserRequest;
use App\Http\Resources\User\GetCommision\SuccessGetCommisionUserResource;

interface GetCommisionUserActionContract
{
    public function __invoke(GetCommisionUserRequest $request): SuccessGetCommisionUserResource;
}

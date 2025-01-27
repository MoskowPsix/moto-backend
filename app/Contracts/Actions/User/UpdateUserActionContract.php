<?php

namespace App\Contracts\Actions\User;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\User\Update\ErrorUpdateUserResource;
use App\Http\Resources\User\Update\SuccessUpdateUserResource;

interface UpdateUserActionContract
{
    public function __invoke(UpdateUserRequest $request): SuccessUpdateUserResource | ErrorUpdateUserResource;
}

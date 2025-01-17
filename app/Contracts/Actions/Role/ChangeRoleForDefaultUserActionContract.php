<?php

namespace App\Contracts\Actions\Role;

use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;

interface ChangeRoleForDefaultUserActionContract
{
    public function __invoke(ChangeRoleForDefaultUserRequest $request): SuccessChangeRoleForDefaultUserResource;
}

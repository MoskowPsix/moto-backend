<?php

namespace App\Contracts\Actions\Controllers\Role;

use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\NoRoleChangeRoleForDefaultUserResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;

interface ChangeRoleForDefaultUserActionContract
{
    public function __invoke(ChangeRoleForDefaultUserRequest $request): SuccessChangeRoleForDefaultUserResource |NoRoleChangeRoleForDefaultUserResource;
}

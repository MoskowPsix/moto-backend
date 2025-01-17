<?php

namespace App\Contracts\Actions\Role;

use App\Http\Resources\Role\GetChangeRole\SuccessGetChangeRoleResource;

interface GetChangeRolesActionContract
{
    public function __invoke(): SuccessGetChangeRoleResource;
}

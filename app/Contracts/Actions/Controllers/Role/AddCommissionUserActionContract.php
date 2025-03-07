<?php

namespace App\Contracts\Actions\Controllers\Role;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;

interface AddCommissionUserActionContract
{
    public function __invoke(int $id): NotFoundResource|SuccessChangeRoleForDefaultUserResource;
}

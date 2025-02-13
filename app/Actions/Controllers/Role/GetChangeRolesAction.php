<?php

namespace App\Actions\Controllers\Role;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Role\GetChangeRolesActionContract;
use App\Http\Resources\Role\GetChangeRole\SuccessGetChangeRoleResource;
use Spatie\Permission\Models\Role;

class GetChangeRolesAction implements GetChangeRolesActionContract
{
    public function __invoke(): SuccessGetChangeRoleResource
    {
        $roles = Role::whereIn('name', [RoleConstant::ORGANIZATION, RoleConstant::RIDER])->get();
        return SuccessGetChangeRoleResource::make($roles);
    }
}

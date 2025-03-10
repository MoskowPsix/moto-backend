<?php

namespace App\Actions\Controllers\Role;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Role\AddCommissionUserActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Models\User;

class AddCommissionUserAction implements AddCommissionUserActionContract
{
    public function __invoke(int $id): NotFoundResource|SuccessChangeRoleForDefaultUserResource
    {
        $user = User::where('id', $id);
        if(!$user->exists()) {
            return new NotFoundResource([]);
        }
        $user->first()->assignRole(RoleConstant::COMMISSION);
        return SuccessChangeRoleForDefaultUserResource::make($user->first());
    }
}

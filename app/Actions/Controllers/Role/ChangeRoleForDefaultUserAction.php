<?php

namespace App\Actions\Controllers\Role;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Role\ChangeRoleForDefaultUserActionContract;
use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\NoRoleChangeRoleForDefaultUserResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ChangeRoleForDefaultUserAction implements ChangeRoleForDefaultUserActionContract
{

    public function __invoke(ChangeRoleForDefaultUserRequest $request): SuccessChangeRoleForDefaultUserResource | NoRoleChangeRoleForDefaultUserResource
    {
        $role = Role::find($request->roleId);

        switch ($role->name) {
            case RoleConstant::RIDER:
                    auth()->user()->assignRole($role);
                break;
            case RoleConstant::COUCH:
            case RoleConstant::ORGANIZATION:
                if (auth()->user()->phone()->exists() &&
                    !empty(auth()->user()->phone()->phone_verified_at)
                ) {
                    auth()->user()->assignRole($role);
                }
                break;
            default:
                return NoRoleChangeRoleForDefaultUserResource::make([]);
        }
        $new_role = Role::find($request->roleId);
        auth()->user()->syncRoles($new_role);
        $user = User::where('id', auth()->id())->with('roles')->firstOrFail();
        return SuccessChangeRoleForDefaultUserResource::make($user);
    }

    public function changeRole(Role $role)
    {

    }
}

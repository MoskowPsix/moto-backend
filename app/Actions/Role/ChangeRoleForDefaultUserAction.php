<?php

namespace App\Actions\Role;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Role\ChangeRoleForDefaultUserActionContract;
use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\NoRoleChangeRoleForDefaultUserResource;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ChangeRoleForDefaultUserAction implements ChangeRoleForDefaultUserActionContract
{

    public function __invoke(ChangeRoleForDefaultUserRequest $request): SuccessChangeRoleForDefaultUserResource | NoRoleChangeRoleForDefaultUserResource
    {
        $rider_role = Role::findByName(RoleConstant::RIDER, 'web');
        $org_role = Role::findByName(RoleConstant::ORGANIZATION, 'web');
        if ($rider_role->id != $request->roleId &&  $org_role->id != $request->roleId) {
            return NoRoleChangeRoleForDefaultUserResource::make([]);
        }
        $new_role = Role::find($request->roleId);
        auth()->user()->syncRoles($new_role);
        $user = User::where('id', auth()->id())->with('roles')->firstOrFail();
        return SuccessChangeRoleForDefaultUserResource::make($user);
    }
}

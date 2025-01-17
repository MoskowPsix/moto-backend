<?php

namespace App\Actions\Role;

use App\Contracts\Actions\Role\ChangeRoleForDefaultUserActionContract;
use App\Http\Requests\Role\ChangeRoleForDefaultUserRequest;
use App\Http\Resources\Role\ChangeRoleForDefaultUser\SuccessChangeRoleForDefaultUserResource;
use App\Models\User;
use Spatie\Permission\Models\Role;

class ChangeRoleForDefaultUserAction implements ChangeRoleForDefaultUserActionContract
{

    public function __invoke(ChangeRoleForDefaultUserRequest $request): SuccessChangeRoleForDefaultUserResource
    {
        $new_role = Role::find($request->roleId);
        auth()->user()->syncRoles($new_role);
        $user = User::where('id', auth()->id())->with('roles')->firstOrFail();
        return SuccessChangeRoleForDefaultUserResource::make($user);
    }
}

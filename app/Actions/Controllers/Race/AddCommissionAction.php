<?php

namespace App\Actions\Controllers\Race;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Race\AddCommissionActionContract;
use App\Http\Requests\Race\AddCommissionRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\User\AddCommission\SuccessAddCommissionResource;
use App\Http\Resources\User\AddCommission\UserIncorectRoleAddCommissionResource;
use App\Models\Race;
use App\Models\User;

class AddCommissionAction implements AddCommissionActionContract
{
    private bool $check_role = true;
    public function __invoke(int $id, AddCommissionRequest $request): NotFoundResource|UserIncorectRoleAddCommissionResource|SuccessAddCommissionResource|NotUserPermissionResource
    {
        $race = Race::find($id);
        if (!$race) {
            return new NotFoundResource([]);
        }
        if($race->user_id !== auth()->user()->id) {
            return NotUserPermissionResource::make([]);
        }

        if(empty($request->usersIds)){
            $race->commissions()->sync([]);
            return SuccessAddCommissionResource::make([
                'message'  => 'Комиссии удалены',
            ]);
        }

        User::whereIn('id', $request->usersIds)->each(function (User $user) {
            if(!$user->hasRole(RoleConstant::COMMISSION)){
                $this->check_role = false;
            }
        });

        if(!$this->check_role) {
            return UserIncorectRoleAddCommissionResource::make([]);
        }
        Race::find($id)->commissions()->sync($request->usersIds);
        return SuccessAddCommissionResource::make([]);
    }
}

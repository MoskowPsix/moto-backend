<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Requests\Race\AddCommissionRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\User\AddCommission\SuccessAddCommissionResource;
use App\Http\Resources\User\AddCommission\UserIncorectRoleAddCommissionResource;

interface AddCommissionActionContract
{
    public function __invoke(int $id, AddCommissionRequest $request):
    NotFoundResource|
    UserIncorectRoleAddCommissionResource|
    SuccessAddCommissionResource|
    NotUserPermissionResource;
}

<?php

namespace App\Contracts\Actions\Controllers\AuthPhoneController;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Phone\Delete\SuccessDeletePhoneResource;

interface DeletePhoneActionContract
{
    public function __invoke(int $id): SuccessDeletePhoneResource|NotFoundResource|NotUserPermissionResource;
}

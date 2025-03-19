<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\Delete\SuccessDeleteRaceResource;

interface DeleteRaceActionContract
{
    public function __invoke(int $id): SuccessDeleteRaceResource|NotFoundResource|NotUserPermissionResource;
}

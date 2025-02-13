<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\ToggleIsWork\SuccessToogleIsWorkRaceResource;

interface ToggleIsWorkRaceActionContract
{
    public function __invoke(int $id): SuccessToogleIsWorkRaceResource|NotFoundResource|NotUserPermissionResource;
}

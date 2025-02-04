<?php

namespace App\Contracts\Actions\Race;

use App\Http\Requests\Race\UpdateRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\Update\SuccessUpdateRaceResource;

interface UpdateRaceActionContract
{
    public function __invoke(int $id, UpdateRaceRequest $request): SuccessUpdateRaceResource|NotFoundResource|NotUserPermissionResource;
}

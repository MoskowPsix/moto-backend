<?php

namespace App\Contracts\Actions\Controllers\Cup;

use App\Http\Requests\Cup\UpdateCupRequest;
use App\Http\Resources\Cup\Update\SuccessUpdateCupResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface UpdateCupActionContract
{
    public function __invoke(int $id, UpdateCupRequest $request): SuccessUpdateCupResource|NotFoundResource|NotUserPermissionResource;
}

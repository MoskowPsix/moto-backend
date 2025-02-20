<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\UpdateCommandRequest;
use App\Http\Resources\Command\Update\SuccessUpdateCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface UpdateCommandActionContract
{
    public function __invoke(int $id, UpdateCommandRequest $request): SuccessUpdateCommandResource|NotFoundResource|NotUserPermissionResource;
}

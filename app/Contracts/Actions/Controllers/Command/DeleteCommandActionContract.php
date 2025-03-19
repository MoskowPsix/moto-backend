<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Resources\Command\Delete\SuccessDeleteCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface DeleteCommandActionContract
{
    public function __invoke(int $id): SuccessDeleteCommandResource|NotFoundResource|NotUserPermissionResource;
}

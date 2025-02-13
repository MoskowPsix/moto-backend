<?php

namespace App\Contracts\Actions\Controllers\Grade;

use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Grade\Update\SuccessUpdateGradeResource;

interface UpdateGradeActionContract
{
    public function __invoke(int $id, UpdateGradeRequest $request): SuccessUpdateGradeResource|NotFoundResource|NotUserPermissionResource;
}

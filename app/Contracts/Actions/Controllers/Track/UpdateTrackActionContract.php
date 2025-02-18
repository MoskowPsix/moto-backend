<?php

namespace App\Contracts\Actions\Controllers\Track;

use App\Http\Requests\Track\UpdateTrackRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Track\Update\SuccessUpdateTrackResource;

interface UpdateTrackActionContract
{
    public function __invoke(int $id, UpdateTrackRequest $request): SuccessUpdateTrackResource|NotFoundResource|NotUserPermissionResource;
}

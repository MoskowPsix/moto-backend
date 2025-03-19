<?php

namespace App\Contracts\Actions\Controllers\Track;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Track\Delete\SuccessDeleteTrackResource;

interface DeleteTrackActionContract
{
    public function __invoke(int $id):SuccessDeleteTrackResource|NotFoundResource|NotUserPermissionResource;
}

<?php

namespace App\Contracts\Actions\Controllers\PersonalInfo;

use App\Http\Requests\PersonalInfo\UpdatePersonalInfoRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoRequest;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoResource;

interface UpdatePersonalInfoActionContract
{
    public function __invoke(UpdatePersonalInfoRequest $request): SuccessUpdatePersonalInfoResource | NotUserPermissionResource | NotFoundResource;
}

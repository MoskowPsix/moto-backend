<?php

namespace App\Contracts\Actions\PersonalInfo;

use App\Http\Requests\PersonalInfo\UpdatePersonalInfoRequest;
use App\Http\Resources\NotFoundResource;
use App\Http\Resources\NotUserPermissionResource;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoRequest;

interface UpdatePersonalInfoActionContract
{
    public function __invoke(int $id, UpdatePersonalInfoRequest $request): SuccessUpdatePersonalInfoRequest | NotUserPermissionResource | NotFoundResource;
}

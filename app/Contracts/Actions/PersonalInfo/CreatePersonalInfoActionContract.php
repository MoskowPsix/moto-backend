<?php

namespace App\Contracts\Actions\PersonalInfo;

use App\Http\Requests\PersonalInfo\CreatePersonalInfoRequest;
use App\Http\Resources\PersonalInfo\Create\SuccessCreatePersonalInfoResource;

interface CreatePersonalInfoActionContract
{
    public function __invoke(CreatePersonalInfoRequest $request): SuccessCreatePersonalInfoResource;

}

<?php

namespace App\Contracts\Actions\Race;

use App\Http\Requests\Race\CreateRaceRequest;
use App\Http\Resources\Race\Create\SuccessCreateRaceResource;

interface CreateRaceActionContract
{
    public function __invoke(CreateRaceRequest $request): SuccessCreateRaceResource;
}

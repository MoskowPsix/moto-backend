<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Requests\Race\GetRaceRequest;
use App\Http\Resources\Race\GetRaces\SuccessGetRaceResource;

interface GetRaceActionContract
{
    public function __invoke(GetRaceRequest $request): SuccessGetRaceResource;

}

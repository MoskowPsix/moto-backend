<?php

namespace App\Actions\Race;

use App\Contracts\Actions\Race\GetRaceActionContract;
use App\Http\Requests\Race\GetRaceRequest;
use App\Http\Resources\Race\GetRaces\SuccessGetRaceResource;
use App\Models\Race;

class GetRaceAction implements GetRaceActionContract
{
    public function __invoke(GetRaceRequest $request): SuccessGetRaceResource
    {
        $races = Race::query()->with('track', 'user')->get();
        return SuccessGetRaceResource::make($races);
    }
}

<?php

namespace App\Actions\Controllers\Cup;

use App\Contracts\Actions\Controllers\Cup\GetForRaceIdCupActionContract;
use App\Http\Requests\Cup\GetForRaceIdCupRequest;
use App\Http\Resources\Cup\GetForRaceId\SuccessGetForRaceIdCupResource;
use App\Models\Race;

class GetForRaceIdCupAction implements GetForRaceIdCupActionContract
{

    public function __invoke(int $raceId, GetForRaceIdCupRequest $request): SuccessGetForRaceIdCupResource
    {
        $race = Race::find($raceId);
        $cups = $race->cups()->get();
        return SuccessGetForRaceIdCupResource::make($cups);
    }
}

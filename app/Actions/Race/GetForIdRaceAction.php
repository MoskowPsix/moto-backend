<?php

namespace App\Actions\Race;

use App\Contracts\Actions\Race\GetForIdRaceActionContract;
use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;
use App\Models\Race;

class GetForIdRaceAction implements GetForIdRaceActionContract
{
    public function __invoke(int $id): SuccessGetRaceForIdResource
    {
        $race = Race::with('track', 'user')->findOrFail($id);
        return SuccessGetRaceForIdResource::make($race);
    }
}

<?php

namespace App\Contracts\Actions\Controllers\Cup;

use App\Http\Requests\Cup\GetForRaceIdCupRequest;
use App\Http\Resources\Cup\GetForRaceId\SuccessGetForRaceIdCupResource;

interface GetForRaceIdCupActionContract
{
    public function __invoke(int $raceId, GetForRaceIdCupRequest $request): SuccessGetForRaceIdCupResource;
}

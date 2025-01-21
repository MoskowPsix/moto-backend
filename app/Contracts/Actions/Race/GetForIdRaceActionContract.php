<?php

namespace App\Contracts\Actions\Race;

use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;

interface GetForIdRaceActionContract
{
    public function __invoke(int $id): SuccessGetRaceForIdResource;

}

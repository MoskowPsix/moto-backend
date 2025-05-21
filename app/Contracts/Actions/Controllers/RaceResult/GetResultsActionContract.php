<?php

namespace App\Contracts\Actions\Controllers\RaceResult;

use App\Http\Requests\RaceResult\GetRaceResultsRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\RaceResult\Get\SuccessGetRaceResultsResource;

interface GetResultsActionContract
{
    public function __invoke(int $id, GetRaceResultsRequest $request):
    SuccessGetRaceResultsResource|
    NotFoundResource;
}

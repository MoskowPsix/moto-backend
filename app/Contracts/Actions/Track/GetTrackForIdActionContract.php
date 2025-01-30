<?php

namespace App\Contracts\Actions\Track;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Track\GetTrackForId\SuccessGetTrackForIdResource;

interface GetTrackForIdActionContract
{
    public function __invoke(int $id): SuccessGetTrackForIdResource | NotFoundResource;

}

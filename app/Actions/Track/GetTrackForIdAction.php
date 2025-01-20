<?php

namespace App\Actions\Track;

use App\Contracts\Actions\Track\GetTrackForIdActionContract;
use App\Http\Resources\Track\GetTrackForId\SuccessGetTrackForIdResource;
use App\Models\Track;

class GetTrackForIdAction implements  GetTrackForIdActionContract
{
    public function __invoke(int $id): SuccessGetTrackForIdResource
    {
        $track = Track::with('level')->findOrFail($id);
        return SuccessGetTrackForIdResource::make($track);
    }
}

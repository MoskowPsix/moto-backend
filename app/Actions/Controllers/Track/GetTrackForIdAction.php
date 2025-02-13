<?php

namespace App\Actions\Controllers\Track;

use App\Contracts\Actions\Controllers\Track\GetTrackForIdActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Track\GetTrackForId\SuccessGetTrackForIdResource;
use App\Models\Track;

class GetTrackForIdAction implements  GetTrackForIdActionContract
{
    public function __invoke(int $id): SuccessGetTrackForIdResource | NotFoundResource
    {
        if (!Track::where('id', $id)->exists()) {
            return NotFoundResource::make([]);
        }
        $track = Track::selectRaw(
            '*, ' . (config('database.default') === 'sqlite' ? 'point' : 'ST_AsGeoJSON(point) as point')
        )->with('level')->findOrFail($id);
//        $track = Track::selectRaw('*, ST_AsGeoJSON(point) as point')->with('level')->findOrFail($id);
        return SuccessGetTrackForIdResource::make($track);
    }
}

<?php

namespace App\Actions\Track;

use App\Contracts\Actions\Track\GetTracksActionContract;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;
use App\Models\Track;

class GetTracksAction implements GetTracksActionContract
{
    public function __invoke(GetTracksRequest $request): SuccessGetTracksResource
    {
        $track = Track::selectRaw('*, ST_AsGeoJSON(point) as point')->with('level')->get();
        return SuccessGetTracksResource::make($track);
    }
}

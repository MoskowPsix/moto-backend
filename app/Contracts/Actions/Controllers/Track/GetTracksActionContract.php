<?php

namespace App\Contracts\Actions\Controllers\Track;

use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;

interface GetTracksActionContract
{
    public function __invoke(GetTracksRequest $request): SuccessGetTracksResource;
}

<?php

namespace App\Contracts\Actions\Track;

use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use App\Http\Resources\User\GetUserForToken\SuccessGetUserForTokenResource;

interface GetTracksActionContract
{
    public function __invoke(GetTracksRequest $request): SuccessGetTracksResource;
}

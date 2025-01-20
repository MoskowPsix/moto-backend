<?php

namespace App\Contracts\Actions\Track;

use App\Http\Requests\Track\CreateTrackRequest;
use App\Http\Resources\Track\Create\ErrorCreateResource;
use App\Http\Resources\Track\Create\SuccessCreateResource;

interface CreateTracksActionContract
{
    public function __invoke(CreateTrackRequest $request): SuccessCreateResource | ErrorCreateResource;
}

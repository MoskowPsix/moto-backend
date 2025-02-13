<?php

namespace App\Contracts\Actions\Controllers\Location;

use App\Http\Requests\Location\GetLocationRequest;
use App\Http\Resources\Location\LocationResource\SuccessGetLocationResource;

interface GetLocationActionContract
{
    public function __invoke(GetLocationRequest $request): SuccessGetLocationResource;
}

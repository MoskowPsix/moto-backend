<?php

namespace App\Actions\Controllers\District;

use App\Contracts\Actions\Controllers\District\GetDistrictsActionContract;
use App\Http\Resources\District\Get\SuccessGetDistricsResource;
use App\Models\District;

class GetDistrictsAction implements GetDistrictsActionContract
{
    public function __invoke():SuccessGetDistricsResource
    {
        return SuccessGetDistricsResource::make(District::all());
    }
}

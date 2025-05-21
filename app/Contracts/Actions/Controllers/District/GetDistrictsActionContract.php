<?php

namespace App\Contracts\Actions\Controllers\District;

use App\Http\Resources\District\Get\SuccessGetDistricsResource;

interface GetDistrictsActionContract
{
    public function __invoke():SuccessGetDistricsResource;
}

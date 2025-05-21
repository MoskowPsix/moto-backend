<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\District\GetDistrictsActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\District\Get\SuccessGetDistricsResource;

class DistrictController extends Controller
{
    public function get(GetDistrictsActionContract $action): SuccessGetDistricsResource
    {
        return $action();
    }
}

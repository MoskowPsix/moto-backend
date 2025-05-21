<?php

namespace App\Actions\Controllers\Degree;

use App\Contracts\Actions\Controllers\Degree\GetDegreeActionContract;
use App\Http\Resources\Degree\Get\SuccessGetDegreeResource;
use App\Models\Degree;

class GetDegreeAction implements GetDegreeActionContract
{
    public function __invoke():SuccessGetDegreeResource
    {
        return SuccessGetDegreeResource::make(Degree::all());
    }
}

<?php

namespace App\Contracts\Actions\Controllers\Degree;

use App\Http\Resources\Degree\Get\SuccessGetDegreeResource;

interface GetDegreeActionContract
{
    public function __invoke():SuccessGetDegreeResource;

}

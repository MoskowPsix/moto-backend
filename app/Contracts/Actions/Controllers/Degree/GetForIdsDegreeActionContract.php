<?php

namespace App\Contracts\Actions\Controllers\Degree;

use App\Http\Resources\Degree\GetForIds\SuccessGetForIdsDegreeResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetForIdsDegreeActionContract
{
    public function __invoke(int $id):
    NotFoundResource|
    SuccessGetForIdsDegreeResource;
}

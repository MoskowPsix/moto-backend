<?php

namespace App\Actions\Controllers\Degree;

use App\Contracts\Actions\Controllers\Degree\GetForIdsDegreeActionContract;
use App\Http\Resources\Degree\GetForIds\SuccessGetForIdsDegreeResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Degree;

class GetDegreeForIdsAction implements GetForIdsDegreeActionContract
{
    public function __invoke(int $id):
    NotFoundResource|
    SuccessGetForIdsDegreeResource
    {
        if (!Degree::where('id', $id)->exists()) {
            return NotFoundResource::make([]);
        }
        return SuccessGetForIdsDegreeResource::make(Degree::find($id));
    }
}

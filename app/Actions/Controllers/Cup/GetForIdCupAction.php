<?php

namespace App\Actions\Controllers\Cup;

use App\Contracts\Actions\Controllers\Cup\GetForIdCupActionContract;
use App\Http\Requests\Cup\GetForIdCupRequest;
use App\Http\Resources\Cup\GetForId\SuccessGetForIdCupResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Cup;

class GetForIdCupAction implements GetForIdCupActionContract
{
    public function __invoke(int $id, GetForIdCupRequest $request): SuccessGetForIdCupResource|NotFoundResource
    {
        $cup = Cup::where('id', $id);
        if(!$cup->exists())
        {
            return NotFoundResource::make([]);
        }
        return SuccessGetForIdCupResource::make($cup->first());
    }
}

<?php

namespace App\Actions\Controllers\Cup;

use App\Contracts\Actions\Controllers\Cup\CreateCupActionContract;
use App\Http\Requests\Cup\CreateCupRequest;
use App\Http\Resources\Cup\Create\SuccessCreateCupResource;
use App\Models\Cup;

class CreateCupAction implements CreateCupActionContract
{

    public function __invoke(CreateCupRequest $request): SuccessCreateCupResource
    {
        $cup = Cup::create([
            'name'          => $request->name,
            'year'          => $request->year,
            'location_id'   => $request->locationId,
            'user_id'       => $request->userId,
        ]);
        return SuccessCreateCupResource::make($cup);
    }
}

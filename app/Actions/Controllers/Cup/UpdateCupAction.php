<?php

namespace App\Actions\Controllers\Cup;

use App\Contracts\Actions\Controllers\Cup\UpdateCupActionContract;
use App\Http\Requests\Cup\UpdateCupRequest;
use App\Http\Resources\Cup\Update\SuccessUpdateCupResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Cup;

class UpdateCupAction implements UpdateCupActionContract
{

    public function __invoke(int $id, UpdateCupRequest $request): SuccessUpdateCupResource|NotFoundResource|NotUserPermissionResource
    {
        $cup = Cup::find($id);
        if(!isset($cup))
        {
            return NotFoundResource::make([]);
        }
        if($cup->user_id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $cup->update([
            'name'          => $request->name ?? $cup->name,
            'year'          => $request->year ?? $cup->year,
            'location_id'   => $request->locationId ?? $cup->location_id,
            'update_id'     => $request->updateId ?? $cup->update_id,
        ]);
        return SuccessUpdateCupResource::make($cup);
    }
}

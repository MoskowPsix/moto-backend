<?php

namespace App\Actions\Controllers\Race;

use App\Contracts\Actions\Controllers\Race\ToggleIsWorkRaceActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\ToggleIsWork\SuccessToogleIsWorkRaceResource;
use App\Models\Race;

class ToggleIsWorkRaceAction implements ToggleIsWorkRaceActionContract
{
    public function __invoke(int $id): SuccessToogleIsWorkRaceResource|NotFoundResource|NotUserPermissionResource
    {
        $user = auth()->user();
        $race = Race::find($id);

        if (!isset($race)) {
            return NotFoundResource::make([]);
        }
        if ($race->user_id !== $user->id) {
            return NotUserPermissionResource::make([]);
        }
        $race->update([
            'is_work' => !$race->is_work,
        ]);
        return SuccessToogleIsWorkRaceResource::make($race);
    }
}

<?php

namespace App\Actions\Controllers\Race;

use App\Contracts\Actions\Controllers\Race\DeleteRaceActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\Delete\SuccessDeleteRaceResource;
use App\Models\Race;

class DeleteRaceAction implements DeleteRaceActionContract
{

    public function __invoke(int $id): SuccessDeleteRaceResource|NotFoundResource|NotUserPermissionResource
    {
        $race = Race::find($id);
        if(!isset($race)){
            return NotFoundResource::make([]);
        }
        if($race->user_id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $race->delete();
        return SuccessDeleteRaceResource::make($race);
    }
}

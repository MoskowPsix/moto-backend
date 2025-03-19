<?php

namespace App\Actions\Controllers\Track;

use App\Contracts\Actions\Controllers\Track\DeleteTrackActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Track\Delete\SuccessDeleteTrackResource;
use App\Models\Track;

class DeleteTrackAction implements DeleteTrackActionContract
{

    public function __invoke(int $id): SuccessDeleteTrackResource|NotFoundResource|NotUserPermissionResource
    {
        $track = Track::find($id);
        if(!isset($track)){
            return NotFoundResource::make([]);
        }
        if($track->user_id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $track->delete();
        return SuccessDeleteTrackResource::make($track);
    }
}

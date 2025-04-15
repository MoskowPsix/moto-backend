<?php

namespace App\Actions\Controllers\AuthPhone;

use App\Contracts\Actions\Controllers\AuthPhoneController\DeletePhoneActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Phone\Delete\SuccessDeletePhoneResource;
use App\Models\Phone;

class DeletePhoneAction implements DeletePhoneActionContract
{

    public function __invoke(int $id): SuccessDeletePhoneResource|NotFoundResource|NotUserPermissionResource
    {
        $phone = Phone::find($id);
        if(!isset($phone)){
            return NotFoundResource::make([]);
        }
        if($phone->user_id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $phone->delete();
        return SuccessDeletePhoneResource::make($phone);
    }
}

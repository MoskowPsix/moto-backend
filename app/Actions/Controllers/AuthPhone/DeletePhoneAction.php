<?php

namespace App\Actions\Controllers\AuthPhone;

use App\Contracts\Actions\Controllers\AuthPhoneController\DeletePhoneActionContract;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Phone\Delete\SuccessDeletePhoneResource;
use App\Models\Phone;
use App\Models\User;

class DeletePhoneAction implements DeletePhoneActionContract
{

    public function __invoke(int $userId): SuccessDeletePhoneResource|NotFoundResource|NotUserPermissionResource
    {
        $user = User::find($userId);

        if(!isset($userId)){
            return NotFoundResource::make([]);
        }
        if($user->id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $phone = $user->phone;
        if(!$phone){
            return NotFoundResource::make([]);
        }
        $phone->delete();
        return SuccessDeletePhoneResource::make($phone);
    }
}

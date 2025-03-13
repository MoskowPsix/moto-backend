<?php

namespace App\Actions\Controllers\AuthPhoneController;

use App\Contracts\Actions\Controllers\AuthPhoneController\VerifyPhoneActionContract;
use App\Http\Requests\AuthPhone\RegisterRequest;
use App\Http\Requests\AuthPhone\VerifyPhoneRequest;
use App\Http\Resources\Auth\Login\SuccessLoginResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Phone;
use Carbon\Carbon;

class VerifyPhoneAction implements VerifyPhoneActionContract
{
    public function __invoke(VerifyPhoneRequest $request):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessLoginResource
    {
        $phone = Phone::where('number', $request->number)->first();
        $p_code = $phone->p_code()->first();
        if (empty($p_code)) {
            return NotFoundResource::make([]);
        }
        if ((int)$p_code->pin != (int)$request->pin) {
            return NotUserPermissionResource::make([]);
        }
        if ($p_code->created_at->addHour(1) < Carbon::now()) {
            return NotUserPermissionResource::make([]);
        }
        if (!isset($phone->number_verified_at)) {
            $phone->update(['number_verified_at' => Carbon::now()]);
        }
        if ($phone->p_code()->exists()) {
            $phone->p_code()->delete();
        }
        return SuccessLoginResource::make($phone->user()->first());
    }
}

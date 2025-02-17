<?php

namespace App\Actions\Controllers\PersonalInfo;

use App\Contracts\Actions\Controllers\PersonalInfo\UpdatePersonalInfoActionContract;
use App\Http\Requests\PersonalInfo\UpdatePersonalInfoRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoRequest;
use App\Http\Resources\PersonalInfo\Update\SuccessUpdatePersonalInfoResource;

class UpdatePersonalInfoAction implements UpdatePersonalInfoActionContract
{

    public function __invoke(UpdatePersonalInfoRequest $request): SuccessUpdatePersonalInfoResource | NotFoundResource | NotUserPermissionResource
    {
        $old_personal = auth()->user()->personalInfo()->first();
        if (!$old_personal->exists()) {
            return NotFoundResource::make([]);
        }
        if ($old_personal->user_id !== auth()->user()->id) {
            return NotUserPermissionResource::make([]);
        }
        $old_personal->update([
            'name'              => $request->name ?? $old_personal->name,
            'surname'           => $request->surname ?? $old_personal->surname,
            'patronymic'        => $request->patronymic ?? $old_personal->patronymic,
            'date_of_birth'     => $request->dateOfBirth ?? $old_personal->date_of_birth,
            'city'              => $request->city ?? $old_personal->city,
            'inn'               => $request->inn ?? $old_personal->inn,
            'snils'             => $request->snils ?? $old_personal->snils,
            'phone_number'      => $request->phoneNumber ?? $old_personal->phone_number,
            'start_number'      => $request->startNumber ?? $old_personal->start_number,
            'group'             => $request->group ?? $old_personal->group,
            'rank_number'       => $request->rankNumber ?? $old_personal->rank_number,
            'rank'              => $request->rank ?? $old_personal->rank,
            'community'         => $request->community ?? $old_personal->community,
            'coach'             => $request->coach ?? $old_personal->coach,
            'moto_stamp'        => $request->motoStamp ?? $old_personal->moto_stamp,
            'engine'            => $request->engine ?? $old_personal->engine,
            'number_and_seria'  => $request->numberAndSeria?? $old_personal->number_and_seria,
            'region'            => $request->region?? $old_personal->region,
            'location_id'       => $request->locationId ?? $old_personal->location_id,
        ]);

        return SuccessUpdatePersonalInfoResource::make(auth()->user()->personalInfo()->with('location')->first());
    }
}

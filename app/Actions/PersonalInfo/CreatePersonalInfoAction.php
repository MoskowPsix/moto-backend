<?php

namespace App\Actions\PersonalInfo;

use App\Contracts\Actions\PersonalInfo\CreatePersonalInfoActionContract;
use App\Http\Requests\PersonalInfo\CreatePersonalInfoRequest;
use App\Http\Resources\PersonalInfo\Create\SuccessCreatePersonalInfoResource;
use App\Models\PersonalInfo;

class CreatePersonalInfoAction implements CreatePersonalInfoActionContract
{
    public function __invoke(CreatePersonalInfoRequest $request): SuccessCreatePersonalInfoResource
    {
        $info = PersonalInfo::create([
            'name'              => $request->name,
            'surname'           => $request->surname,
            'patronymic'        => $request->patronymic,
            'date_of_birth'     => $request->dateOfBirth,
            'city'              => $request->city,
            'inn'               => $request->inn,
            'snils'             => $request->snils,
            'phone_number'      => $request->phoneNumber,
            'start_number'      => $request->startNumber,
            'group'             => $request->group,
            'rank_number'       => $request->rankNumber,
            'rank'              => $request->rank,
            'community'         => $request->community,
            'coach'             => $request->coach,
            'moto_stamp'        => $request->motoStamp,
            'engine'            => $request->engine,
            'user_id'           => auth()->user()->id,
            'number_and_seria'  => $request->numberAndSeria,
        ]);
        return SuccessCreatePersonalInfoResource::make($info);
    }
}

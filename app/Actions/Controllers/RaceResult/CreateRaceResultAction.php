<?php

namespace App\Actions\Controllers\RaceResult;

use \App\Contracts\Actions\Controllers\RaceResult\CreateRaceResultActionContract;
use App\Http\Requests\RaceResult\CreateRaceResultRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\RaceResult\Create\SuccessCreateRaceResultResource;
use App\Models\Race;
use App\Models\RaceResult;


class CreateRaceResultAction implements CreateRaceResultActionContract
{
    public function __invoke(int $id, CreateRaceResultRequest $request):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessCreateRaceResultResource
    {
        $race_q = Race::where('id', $id);
        $user = auth()->user();

        if(!$race_q->exists()) {
            return NotFoundResource::make([]);
        }
        if (!$race_q->first()->commissions()->where('users.id', $user->id)->exists())
        {
            return NotUserPermissionResource::make([]);
        }

        $result = $race_q->first()->raceResult()->create([
            'user_id'       => $request->userId,
            'cup_id'        => $request->cupId,
            'command_id'    => $request->commandId,
            'scores'        => $request->scores,
            'place'         => $request->place,
            'grade_id'      => $request->gradeId
        ]);

        return SuccessCreateRaceResultResource::make(RaceResult::with(['user', 'race', 'command', 'cup', 'grade'])->where('id', $result->id)->first());
    }
}

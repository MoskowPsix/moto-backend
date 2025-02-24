<?php

namespace App\Actions\Controllers\AppointmentRace;

use App\Contracts\Actions\Controllers\AppointmentRace\ToggleAppointmentRaceActionContract;
use App\Enums\DocumentType;
use App\Http\Requests\AppointmentRace\ToogleAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\Create\ExistsAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\GradeNotExistsAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\ManyDocumentAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\AppointmentRace;
use App\Models\Document;
use App\Models\Race;

class ToggleAppointmentRaceAction implements ToggleAppointmentRaceActionContract
{

    public function __invoke(int $id, ToogleAppointmentRaceRequest $request):
    SuccessCreateAppointmentRaceResource|
    NotFoundResource|
    SuccessDeleteAppointmentRaceResource|
    ManyDocumentAppointmentRaceResource|
    ExistsAppointmentRaceResource|
    GradeNotExistsAppointmentRaceResource
    {
        $user = auth()->user();
        $race = Race::find($id);
        if (!$race) {
            return new NotFoundResource([]);
        }
        if ($race->appointments()->where('user_id', $user->id)->exists()) {
            return ExistsAppointmentRaceResource::make([]);
        }
        if (!$race->grades()->where('grade_id', $request->gradeId)->exists()) {
            return GradeNotExistsAppointmentRaceResource::make([]);
        }

        return $this->createAppointment($user->id, $race->id, $request);
    }

    private function deleteAppointment(int $user_id, int $race_id): SuccessDeleteAppointmentRaceResource
    {
        $val = AppointmentRace::where('user_id', $user_id)->where('race_id', $race_id)->first();
        $val->delete();
        return SuccessDeleteAppointmentRaceResource::make([]);
    }
    private function createAppointment(int $user_id, int $race_id, $request): SuccessCreateAppointmentRaceResource | ManyDocumentAppointmentRaceResource
    {
        $types = Document::whereIn('id', $request->documentIds)->pluck('type')->toArray();
        if (count( array_keys( $types, DocumentType::Licenses)) >= 2) {
            return ManyDocumentAppointmentRaceResource::make([]);
        }
        if (count( array_keys( $types, DocumentType::Notarius)) >= 2) {
            return ManyDocumentAppointmentRaceResource::make([]);
        }
        $app = AppointmentRace::create([
            'user_id'               => $user_id,
            'race_id'               => $race_id,
            'surname'               => $request->surname,
            'name'                  => $request->name,
            'patronymic'            => $request->patronymic,
            'engine'                => $request->engine,
            'start_number'          => $request->startNumber,
            'rank'                  => $request->rank,
            'date_of_birth'         => $request->dateOfBirth,
            'community'             => $request->community,
            'moto_stamp'            => $request->motoStamp,
            'number_and_seria'      => $request->numberAndSeria,
            'snils'                 => $request->snils,
            'phone_number'          => $request->phoneNumber,
            'coach'                 => $request->coach,
            'inn'                   => $request->inn,
            'city'                  => $request->city,
            'location_id'           => $request->locationId,
            'grade_id'              => $request->gradeId,
        ]);

        foreach($request->documentIds as $documentId) {
            if (!auth()->user()->documents()->where('id', $documentId)->exists()) {
                break;
            }
            $app->documents()->attach($documentId);
        }
        return new SuccessCreateAppointmentRaceResource([]);
    }
}

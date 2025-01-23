<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\AppointmentRace\ToggleAppointmentRaceActionContract;
use App\Contracts\Actions\AppointmentRace\DeleteAppointmentRaceActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'AppointmentRace', description: 'Методы отвечающие за запись участников')]
class AppointmentRaceController extends Controller
{
    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateAppointmentRaceResource::class)]
    #[ResponseFromApiResource(SuccessDeleteAppointmentRaceResource::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'toggle', description: 'Записаться и отменить запись на гонку')]

    public function toggle(int $id, ToggleAppointmentRaceActionContract $action): SuccessCreateAppointmentRaceResource | NotFoundResource | SuccessDeleteAppointmentRaceResource
    {
        return $action($id);
    }
//    public function delete(int $id, DeleteAppointmentRaceActionContract $action): SuccessDeleteAppointmentRaceResource | NotFoundResource
//    {
//        return $action($id);
//    }
}

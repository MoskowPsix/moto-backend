<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Contracts\Actions\AppointmentRace\GetUsersAppointmentRaceActionContract;
use App\Contracts\Actions\AppointmentRace\ToggleAppointmentRaceActionContract;
use App\Contracts\Actions\AppointmentRace\DeleteAppointmentRaceActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRace\GetUsersAppointmentRaceRequest;
use App\Http\Requests\AppointmentRace\ToogleAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\GetUsers\SuccessGetUsersAppointmentResource;
use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\User;
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
    public function toggle(int $id, ToogleAppointmentRaceRequest $request, ToggleAppointmentRaceActionContract $action): SuccessCreateAppointmentRaceResource | NotFoundResource | SuccessDeleteAppointmentRaceResource
    {
        return $action($id, $request);
    }
    #[ResponseFromApiResource(SuccessGetUsersAppointmentResource::class, User::class, collection: true)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'GetUsersAppointmentRace', description: 'Записаться и отменить запись на гонку')]
    public function getUsersAppointmentRace(int $id, GetUsersAppointmentRaceRequest $request, GetUsersAppointmentRaceActionContract $action): SuccessGetUsersAppointmentResource | NotFoundResource
    {
        return $action($id, $request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(CreateTableAppointmentRaceUserActionContract::class)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'getTable', description: 'Получить ссылку на таблицу участников')]
    public function getUsersAppointmentRaceInTable(int $id, CreateTableAppointmentRaceUserActionContract $action): SuccessCreateTableAppointmentRaceResource | NotUserPermissionResource
    {
        return $action($id);
    }
//    public function delete(int $id, DeleteAppointmentRaceActionContract $action): SuccessDeleteAppointmentRaceResource | NotFoundResource
//    {
//        // Функции этого метода выполняет метод toggle, по этому он убран.
//        return $action($id);
//    }
}

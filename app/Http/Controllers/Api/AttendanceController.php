<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\AppointmentRace\CheckedAppointmentRaceForCommissionActionContract;
use App\Contracts\Actions\Controllers\Attendance\CreateAttendanceActionContract;
use App\Contracts\Actions\Controllers\Attendance\DeleteAttendanceActionContract;
use App\Contracts\Actions\Controllers\Attendance\GetAttendanceActionContract;
use App\Contracts\Actions\Controllers\Attendance\GetForIdAttendanceActionContract;
use App\Contracts\Actions\Controllers\Attendance\UpdateAttendanceActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRace\CheckedAppointmentRaceForCommissionRequest;
use App\Http\Requests\Attendance\CreateAttendanceRequest;
use App\Http\Requests\Attendance\DeleteAttendanceRequest;
use App\Http\Requests\Attendance\GetAttendanceRequest;
use App\Http\Requests\Attendance\GetForIdAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Http\Resources\AppointmentRace\Checked\SuccessCheckedAppointmentRaceForCommissionResource;
use App\Http\Resources\Attendance\Create\SuccessCreateAttendanceResource;
use App\Http\Resources\Attendance\Delete\SuccessDeleteAttendanceResource;
use App\Http\Resources\Attendance\GetAttendance\SuccessGetAttendanceResource;
use App\Http\Resources\Attendance\GetAttendanceForId\SuccessGetAttendanceForIdResource;
use App\Http\Resources\Attendance\Update\SuccessUpdateAttendanceResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Attendance', description: 'Методы связанные с платными услугами.')]
class AttendanceController extends Controller
{
    #[ResponseFromApiResource(SuccessGetAttendanceForIdResource::class, Attendance::class, collection: false)]
    #[Endpoint(title: 'getForId', description: 'Получение платных услуг по id.')]
    public function getForID(int $id, GetForIdAttendanceRequest $request, GetForIdAttendanceActionContract $action): SuccessGetAttendanceForIdResource
    {
        return $action($id, $request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateAttendanceResource::class, Attendance::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание платной услуги.')]
    public function create(CreateAttendanceRequest $request, CreateAttendanceActionContract $action): SuccessCreateAttendanceResource
    {
        return $action($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessUpdateAttendanceResource::class, Attendance::class, collection: false)]
    #[Endpoint(title: 'update', description: 'Редактирование платной услуги.')]
    public function update(int $id, UpdateAttendanceRequest $request, UpdateAttendanceActionContract $action): SuccessUpdateAttendanceResource
    {
        return $action($id, $request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessDeleteAttendanceResource::class, Attendance::class, collection: false)]
    #[Endpoint(title: 'delete', description: 'Удаление платной услуги.')]
    public function delete(int $id, DeleteAttendanceRequest $request, DeleteAttendanceActionContract $action): SuccessDeleteAttendanceResource
    {
        return $action($id, $request);
    }
}

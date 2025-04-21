<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\AppointmentRace\CreateTableAppointmentRaceUserActionContract;
use App\Contracts\Actions\Controllers\AppointmentRace\GetAppointmentPDFActionContract;
use App\Contracts\Actions\Controllers\AppointmentRace\GetAppointmentRaceUsersForCommissionActionContract;
use App\Contracts\Actions\Controllers\AppointmentRace\GetUsersAppointmentRaceActionContract;
use App\Contracts\Actions\Controllers\AppointmentRace\ToggleAppointmentRaceActionContract;
use App\Contracts\Actions\Controllers\Export\MultiSheetAppointmentRaceExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRace\GetAppointmentRaceUsersForCommissionRequest;
use App\Http\Requests\AppointmentRace\GetUsersAppointmentRaceRequest;
use App\Http\Requests\AppointmentRace\ToogleAppointmentRaceRequest;
use App\Http\Resources\AppointmentRace\Create\ExistsAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\GradeNotExistsAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\ManyDocumentAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Create\SuccessCreateAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\Delete\SuccessDeleteAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\GetUsers\SuccessGetUsersAppointmentResource;
use App\Http\Resources\AppointmentRace\SuccessCreateTableAppointmentRaceResource;
use App\Http\Resources\AppointmentRace\SuccessGetAppointmentRaceUsersForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\User;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;
use Knuckles\Scribe\Attributes\ResponseFromFile;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

#[Group(name: 'AppointmentRace', description: 'Методы отвечающие за запись участников')]
class AppointmentRaceController extends Controller
{
    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateAppointmentRaceResource::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(ManyDocumentAppointmentRaceResource::class, status: 422)]
    #[ResponseFromApiResource(ExistsAppointmentRaceResource::class, status: 409)]
    #[ResponseFromApiResource(GradeNotExistsAppointmentRaceResource::class, status: 404)]
    #[Endpoint(title: 'Toggle', description: 'Записаться и отменить запись на гонку')]
    public function toggle(int $id, ToogleAppointmentRaceRequest $request, ToggleAppointmentRaceActionContract $action):
    SuccessCreateAppointmentRaceResource|
    NotFoundResource|
    ManyDocumentAppointmentRaceResource|
    ExistsAppointmentRaceResource|
    GradeNotExistsAppointmentRaceResource|
    NotUserPermissionResource
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
    #[ResponseFromApiResource(SuccessCreateTableAppointmentRaceResource::class)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'GetTable', description: 'Получить ссылку на таблицу участников')]
    public function getUsersAppointmentRaceInTable(int $id, CreateTableAppointmentRaceUserActionContract $action): SuccessCreateTableAppointmentRaceResource | NotUserPermissionResource | NotFoundResource
    {
        return $action($id);
    }
    #[Authenticated]
    #[ResponseFromFile(file: "storage/app/private/user/documents/URsB0gs6G0ATlQnF2TdirtS1hCOJfMOFoxmkBWgo.png")]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'GetAppointmentPDF', description: 'Возвращает документ заявки гонщика для комиссии')]
    public function getAppointmentPDF(int $id, GetAppointmentPDFActionContract $action): BinaryFileResponse|NotFoundResource
    {
        return $action($id);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetAppointmentRaceUsersForCommissionResource::class, User::class)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'GetAppointmentsUsers', description: 'Возвращает пользователей для комиссии.')]
    public function getAppointmentsUsers(int $id, GetAppointmentRaceUsersForCommissionRequest $request, GetAppointmentRaceUsersForCommissionActionContract $action):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessGetAppointmentRaceUsersForCommissionResource
    {
        return $action($id, $request);
    }
//    public function delete(int $id, DeleteAppointmentRaceActionContract $action): SuccessDeleteAppointmentRaceResource | NotFoundResource
//    {
//        // Функции этого метода выполняет метод toggle, по этому он убран.
//        return $action($id);
//    }
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    #[Authenticated]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'Export', description: 'Экспорт заявок')]
    public function export(int $id)
    {
//        $userId = \Auth::id();
        return Excel::download(new MultiSheetAppointmentRaceExport($id), 'регистрация мотокросс.xlsx');
    }
}

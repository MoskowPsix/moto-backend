<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Command\AddCouchActionContract;
use App\Contracts\Actions\Controllers\Command\CreateCommandActionContract;
use App\Contracts\Actions\Controllers\Command\DeleteCommandActionContract;
use App\Contracts\Actions\Controllers\Command\GetCoachesForAllUsersActionContract;
use App\Contracts\Actions\Controllers\Command\GetCommandActionContract;
use App\Contracts\Actions\Controllers\Command\GetCommandForCoachIdActionContract;
use App\Contracts\Actions\Controllers\Command\GetCouchesActionContract;
use App\Contracts\Actions\Controllers\Command\GetForIdCommandActionContract;
use App\Contracts\Actions\Controllers\Command\GetMembersActionContract;
use App\Contracts\Actions\Controllers\Command\GetMembersForCoachActionContract;
use App\Contracts\Actions\Controllers\Command\ToggleMemberActionContract;
use App\Contracts\Actions\Controllers\Command\UpdateCommandActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Command\CreateCommandRequest;
use App\Http\Requests\Command\GetCoachesForAllUsersRequest;
use App\Http\Requests\Command\GetCommandRequest;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Requests\Command\GetForCoachIdCommandRequest;
use App\Http\Requests\Command\GetForIdCommandRequest;
use App\Http\Requests\Command\UpdateCommandRequest;
use App\Http\Resources\Command\AddCouch\SuccessAddCouchCommandResource;
use App\Http\Resources\Command\Create\SuccessCreateCommandResource;
use App\Http\Resources\Command\Delete\SuccessDeleteCommandResource;
use App\Http\Resources\Command\GetCoachesForAll\SuccessGetCoachesForAllCommandResource;
use App\Http\Resources\Command\GetCommand\SuccessGetCommandResource;
use App\Http\Resources\Command\GetCommandForCoach\SuccessGetCommandForCoachIdResource;
use App\Http\Resources\Command\GetCommandForId\SuccessGetCommandForIdResource;
use App\Http\Resources\Command\GetCouches\SuccessGetCouchesCommandResource;
use App\Http\Resources\Command\GetMember\SuccessGetMemberCommandResource;
use App\Http\Resources\Command\GetMembersForCoach\GetMembersForCoachCommandResource;
use App\Http\Resources\Command\ToggleMember\SuccessToggleMemberCommandResource;
use App\Http\Resources\Command\Update\SuccessUpdateCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Command', description: 'Методы связанные с командами')]
class CommandController extends Controller
{
    #[ResponseFromApiResource(SuccessGetCommandResource::class, Command::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение всех команд по фильтрам')]
    public function get(GetCommandRequest $request, GetCommandActionContract $action): SuccessGetCommandResource
    {
        return $action($request);
    }

    #[ResponseFromApiResource(SuccessGetCommandForIdResource::class, Command::class, collection: false)]
    #[Endpoint(title: 'getForId', description: 'Получение команд по id')]
    public function getForID(int $id, GetForIdCommandRequest $request, GetForIdCommandActionContract $action): SuccessGetCommandForIdResource
    {
        return $action($id, $request);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateCommandResource::class, Command::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание команды')]
    public function create(CreateCommandRequest $request, CreateCommandActionContract $action): SuccessCreateCommandResource
    {
        return $action($request);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessUpdateCommandResource::class, Command::class, collection: false)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'update', description: 'Редактирование команды')]
    public function update(int $id, UpdateCommandRequest $request, UpdateCommandActionContract $action): SuccessUpdateCommandResource|NotFoundResource|NotUserPermissionResource
    {
        return $action($id, $request);
    }

    #[ResponseFromApiResource(SuccessDeleteCommandResource::class, Command::class, collection: false)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'delete', description: 'Удаление команды')]
    public function delete(int $id, DeleteCommandActionContract $action): SuccessDeleteCommandResource|NotFoundResource|NotUserPermissionResource
    {
        return $action($id);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetCouchesCommandResource::class, User::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'getCoaches', description: 'Получение всех тренеров команды.')]
    public function getCoaches(int $id, GetCouchesCommandRequest $request, GetCouchesActionContract $action):
    NotFoundResource|
    SuccessGetCouchesCommandResource
    {
        return $action($id, $request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(SuccessAddCouchCommandResource::class)]
    #[Endpoint(title: 'toggleCouch', description: 'Добавление и удаление тренера из команды, может пользоваться только владелец команды.')]
    public function toggleCouch(int $command_id, int $user_id, AddCouchActionContract $action):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessAddCouchCommandResource
    {
        return $action($command_id, $user_id);
    }
    #[Authenticated]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(SuccessGetMemberCommandResource::class, User::class)]
    #[Endpoint(title: 'getMembers', description: 'Получить всех участников команды.')]
    public function getMembers(int $id, GetCouchesCommandRequest $request, GetMembersActionContract $action):
    NotFoundResource|
    SuccessGetMemberCommandResource
    {
        return $action($id, $request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(SuccessToggleMemberCommandResource::class)]
    #[Endpoint(title: 'toggleMember', description: 'Привязка пользователя к команде от имени самого пользователя.')]
    public function toggleMember(int $command_id, ToggleMemberActionContract $action):NotFoundResource|SuccessToggleMemberCommandResource
    {
        return $action($command_id);
    }
    #[Authenticated]
    #[ResponseFromApiResource(SuccessGetCommandForCoachIdResource::class, User::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'getCommandsForCoachId', description: 'Получение всех команд по тренеру.')]
    public function getCommandsForCoachId(GetForCoachIdCommandRequest $request, GetCommandForCoachIdActionContract $action): SuccessGetCommandForCoachIdResource|NotFoundResource|NotUserPermissionResource
    {
        return $action($request);
    }
    #[Authenticated]
    #[ResponseFromApiResource(GetMembersForCoachCommandResource::class, User::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[ResponseFromApiResource(NotUserPermissionResource::class, status: 403)]
    #[Endpoint(title: 'getMembersForCoach', description: 'Получение всех участников по тренеру.')]
    public function getMembersForCoach(int $id, GetMembersForCoachActionContract $action, GetCouchesCommandRequest $request):
    NotUserPermissionResource|
    NotFoundResource|
    GetMembersForCoachCommandResource
    {
        return $action($id, $request);
    }
    #[ResponseFromApiResource(SuccessGetCoachesForAllCommandResource::class, User::class)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'getCoachesForAll', description: 'Получение всех тренеров по команде для всех.')]
    public function getCoachesForAll(int $id, GetCoachesForAllUsersRequest $request, GetCoachesForAllUsersActionContract $action):
    SuccessGetCoachesForAllCommandResource|
    NotFoundResource
    {
        return $action($id, $request);
    }
//    public function getMemberForCoachForId($command_id, $user_id)
//    {
//
//    }
}

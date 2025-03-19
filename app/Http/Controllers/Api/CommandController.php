<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Command\CreateCommandActionContract;
use App\Contracts\Actions\Controllers\Command\DeleteCommandActionContract;
use App\Contracts\Actions\Controllers\Command\GetCommandActionContract;
use App\Contracts\Actions\Controllers\Command\GetForIdCommandActionContract;
use App\Contracts\Actions\Controllers\Command\UpdateCommandActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Command\CreateCommandRequest;
use App\Http\Requests\Command\GetCommandRequest;
use App\Http\Requests\Command\GetForIdCommandRequest;
use App\Http\Requests\Command\UpdateCommandRequest;
use App\Http\Resources\Command\Create\SuccessCreateCommandResource;
use App\Http\Resources\Command\Delete\SuccessDeleteCommandResource;
use App\Http\Resources\Command\GetCommand\SuccessGetCommandResource;
use App\Http\Resources\Command\GetCommandForId\SuccessGetCommandForIdResource;
use App\Http\Resources\Command\Update\SuccessUpdateCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
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
    #[Endpoint(title: 'getCoaches', description: 'Получение всех тренеров команды.')]
    public function getCoaches(int $id)
    {}
    #[Authenticated]
    #[Endpoint(title: 'toggleCouch', description: 'Добавление и удаление тренера из команды.')]
    public function addCouch(int $command_id, int $user_id)
    {}
    #[Authenticated]
    #[Endpoint(title: 'getMembers', description: 'Получить всех участников команды.')]
    public function getMembers(int $id)
    {}
    #[Authenticated]
    #[Endpoint(title: 'toggleMember', description: 'Привязка пользователя к команде')]
    public function toggleMember(int $command_id, int $user_id)
    {}
}

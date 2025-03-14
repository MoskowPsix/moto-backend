<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Status\GetStatusesActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\Status\GetStatuses\SuccessGetStatusesResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Status', description: 'Методы связанные с статусами гонок')]
class StatusController extends Controller
{
    #[ResponseFromApiResource(SuccessGetStatusesResource::class, Status::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение всех статусов')]
    public function get(GetStatusesActionContract $action): SuccessGetStatusesResource
    {
        return $action();
    }
}

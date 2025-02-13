<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Grade\CreateGradeActionContract;
use App\Contracts\Actions\Controllers\Grade\GetForIdGradeActionContract;
use App\Contracts\Actions\Controllers\Grade\GetGradeActionContract;
use App\Contracts\Actions\Controllers\Grade\UpdateGradeActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Grade\CreateGradeRequest;
use App\Http\Requests\Grade\GetForIdGradeRequest;
use App\Http\Requests\Grade\GetGradeRequest;
use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Grade\Create\SuccessCreateGradeResource;
use App\Http\Resources\Grade\GetGrade\SuccessGetGradeResource;
use App\Http\Resources\Grade\GetGradeForId\SuccessGetGradeForIdResource;
use App\Http\Resources\Grade\Update\SuccessUpdateGradeResource;
use App\Models\Grade;
use Knuckles\Scribe\Attributes\Authenticated;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Grade', description: 'Методы связанные с классами')]
class GradeController extends Controller
{
    #[ResponseFromApiResource(SuccessGetGradeResource::class, Grade::class, collection: true)]
    #[Endpoint(title: 'get', description: 'Получение всех классов по фильтрам')]
    public function get(GetGradeRequest $request, GetGradeActionContract $action): SuccessGetGradeResource
    {
        return $action($request);
    }

    #[ResponseFromApiResource(SuccessGetGradeForIdResource::class, Grade::class, collection: false)]
    #[Endpoint(title: 'getForId', description: 'Получение класса по id')]
    public function getForID(int $id, GetForIdGradeRequest $request, GetForIdGradeActionContract $action): SuccessGetGradeForIdResource
    {
        return $action($id, $request);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessCreateGradeResource::class, Grade::class, collection: false)]
    #[Endpoint(title: 'create', description: 'Создание класса')]
    public function create(CreateGradeRequest $request, CreateGradeActionContract $action): SuccessCreateGradeResource
    {
        return $action($request);
    }

    #[Authenticated]
    #[ResponseFromApiResource(SuccessUpdateGradeResource::class, Grade::class, collection: false)]
    #[ResponseFromApiResource(NotFoundResource::class, status: 404)]
    #[Endpoint(title: 'update', description: 'Редактирование класса')]
    public function update(int $id, UpdateGradeRequest $request, UpdateGradeActionContract $action): SuccessUpdateGradeResource
    {
        return $action($id, $request);
    }
}

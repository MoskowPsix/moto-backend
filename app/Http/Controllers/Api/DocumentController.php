<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Document\CreateDocumentActionContract;
use App\Contracts\Actions\Document\GetDocumentForUserActionContract;
use App\Contracts\Actions\Document\GetDocumentForUserByIdActionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;
use App\Http\Resources\Document\GetForUserById\NotFoundGetDocumentForUserByIdResource;
use App\Http\Resources\Document\GetForUserById\SuccessGetDocumentForUserByIdResource;
use App\Models\Document;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\ResponseFromApiResource;

#[Group(name: 'Document', description: 'Методы взаимодействия с документами пользователя')]
class DocumentController extends Controller
{
    #[ResponseFromApiResource(SuccessGetDocumentForUserResource::class, Document::class, collection: true)]
    #[Endpoint(title: 'GetForUser', description: 'Получение всех документов пользователя')]
    public function getForUser(GetDocumentForUserRequest $request, GetDocumentForUserActionContract $action): SuccessGetDocumentForUserResource
    {
        return $action($request);
    }
    #[ResponseFromApiResource(SuccessGetDocumentForUserByIdResource::class, Document::class, collection: false)]
    #[ResponseFromApiResource(NotFoundGetDocumentForUserByIdResource::class, status: 404)]
    #[Endpoint(title: 'GetForUserById', description: 'Получение документа пользователя по id')]
    public function getForUserById($id, GetDocumentForUserByIdActionContract $action): NotFoundGetDocumentForUserByIdResource | SuccessGetDocumentForUserByIdResource
    {
        return $action($id);
    }
    #[ResponseFromApiResource(SuccessCreateDocumentResource::class, Document::class, collection: false)]
    #[Endpoint(title: 'Create', description: 'Создание документа пользователя')]
    public function create(CreateDocumentRequest $request, CreateDocumentActionContract $action): SuccessCreateDocumentResource
    {
        return $action($request);
    }
}

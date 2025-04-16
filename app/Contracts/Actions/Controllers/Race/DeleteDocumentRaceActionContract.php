<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Requests\Race\DeleteDocumentsRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\DeleteDocument\SuccessDeleteDocumentRaceResource;

interface DeleteDocumentRaceActionContract
{
    public function __invoke(int $id, DeleteDocumentsRaceRequest $request): SuccessDeleteDocumentRaceResource|NotFoundResource|NotUserPermissionResource;
}

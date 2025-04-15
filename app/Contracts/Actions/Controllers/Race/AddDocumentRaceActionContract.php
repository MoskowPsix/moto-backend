<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Requests\Race\AddDocumentsRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\AddDocument\SuccessAddDocumentRaceResource;

interface AddDocumentRaceActionContract
{
    public function __invoke(int $id, AddDocumentsRaceRequest $request): SuccessAddDocumentRaceResource|NotFoundResource|NotUserPermissionResource;
}

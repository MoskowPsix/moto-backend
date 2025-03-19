<?php

namespace App\Contracts\Actions\Controllers\Document;

use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface GetDocumentForUserActionContract
{
    public function __invoke(GetDocumentForUserRequest $request): SuccessGetDocumentForUserResource|NotUserPermissionResource;

}

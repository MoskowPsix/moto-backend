<?php

namespace App\Contracts\Actions\Controllers\Document;

use App\Http\Resources\Document\Delete\SuccessDeleteDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface DeleteDocumentActionContract
{
    public function __invoke(int $id): SuccessDeleteDocumentResource | NotFoundResource | NotUserPermissionResource;
}

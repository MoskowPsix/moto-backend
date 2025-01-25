<?php

namespace App\Contracts\Actions\Document;

use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Resources\Document\Update\SuccessUpdateDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;

interface UpdateDocumentActionContract
{
    public function __invoke(int $id, UpdateDocumentRequest $request): SuccessUpdateDocumentResource | NotFoundResource | NotUserPermissionResource;
}

<?php

namespace App\Contracts\Actions\Controllers\Document;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

interface GetFileDocumentActionContract
{
    public function __invoke(int $id): BinaryFileResponse|NotFoundResource|NotUserPermissionResource;
}

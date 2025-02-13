<?php

namespace App\Contracts\Actions\Controllers\Document;

use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;

interface GetDocumentForUserActionContract
{
    public function __invoke(GetDocumentForUserRequest $request): SuccessGetDocumentForUserResource;

}

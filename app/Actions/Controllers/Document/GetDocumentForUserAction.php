<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\GetDocumentForUserActionContract;
use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;

class GetDocumentForUserAction implements  GetDocumentForUserActionContract
{
    public function __invoke(GetDocumentForUserRequest $request): SuccessGetDocumentForUserResource
    {
        $docs = auth()->user()->documents()->get();
        return SuccessGetDocumentForUserResource::make($docs);
    }
}

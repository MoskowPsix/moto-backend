<?php

namespace App\Contracts\Actions\Controllers\Document;

use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;

interface CreateDocumentActionContract
{
    public function __invoke(CreateDocumentRequest $request): SuccessCreateDocumentResource;

}

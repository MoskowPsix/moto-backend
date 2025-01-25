<?php

namespace App\Actions\Document;

use App\Contracts\Actions\Document\GetDocumentForUserByIdActionContract;
use App\Http\Resources\Document\GetForUserById\NotFoundGetDocumentForUserByIdResource;
use App\Http\Resources\Document\GetForUserById\SuccessGetDocumentForUserByIdResource;
use App\Models\Document;

class GetDocumentForUserByIdAction implements GetDocumentForUserByIdActionContract
{
    public function __invoke($id): NotFoundGetDocumentForUserByIdResource | SuccessGetDocumentForUserByIdResource
    {
        $documents_q = Document::where('user_id', auth()->user()->id)->where('id', $id);
        if (!$documents_q->exists()) {
            return NotFoundGetDocumentForUserByIdResource::make([]);
        }
        return SuccessGetDocumentForUserByIdResource::make($documents_q->first());
    }
}

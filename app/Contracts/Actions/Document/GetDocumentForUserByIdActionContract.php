<?php

namespace App\Contracts\Actions\Document;

use App\Http\Resources\Document\GetForUserById\NotFoundGetDocumentForUserByIdResource;
use App\Http\Resources\Document\GetForUserById\SuccessGetDocumentForUserByIdResource;

interface GetDocumentForUserByIdActionContract
{
    public function __invoke($id): NotFoundGetDocumentForUserByIdResource | SuccessGetDocumentForUserByIdResource;

}

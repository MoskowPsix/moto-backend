<?php

namespace App\Contracts\Actions\Controllers\Document;

use App\Http\Requests\Document\VerifyDocsForCommissionDocumentRequest;
use App\Http\Resources\Document\VerifyDocsForCommission\SuccessVerifyDocsForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;

interface VerifyDocsForCommissionActionContract
{
    public function __invoke(int $id, VerifyDocsForCommissionDocumentRequest $request): SuccessVerifyDocsForCommissionResource|NotFoundResource;
}

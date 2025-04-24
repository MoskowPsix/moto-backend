<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\VerifyDocsForCommissionActionContract;
use App\Http\Requests\Document\VerifyDocsForCommissionDocumentRequest;
use App\Http\Resources\Document\VerifyDocsForCommission\SuccessVerifyDocsForCommissionResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Document;
use Carbon\Carbon;

class VerifyDocsForCommissionAction implements VerifyDocsForCommissionActionContract
{
    public function __invoke(int $id, VerifyDocsForCommissionDocumentRequest $request): SuccessVerifyDocsForCommissionResource|NotFoundResource
    {
        $doc = Document::where('id', $id);
        if (!$doc->exists()) {
            return new NotFoundResource([]);
        };
        Document::find($id)->update([
            'is_checked'    => $request->checked ? Carbon::now() : null,
            'comment'       => $request->comment,
            'commission_id' => auth()->user()->id,
        ]);
        return SuccessVerifyDocsForCommissionResource::make([]);
    }
}

<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\CreateDocumentActionContract;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Models\Document;
use Carbon\Carbon;

class CreateDocumentAction implements CreateDocumentActionContract
{
    public function __invoke(CreateDocumentRequest $request): SuccessCreateDocumentResource
    {
        if (isset($request->file)) {
            $path = $this->save($request->file);
        }
        $name = uniqid('file_');
        $user = auth()->user();
        $document = Document::create([
            'name'          => $name,
            'type'          => $request->type,
            'path'          => $path ?? '',
            'number'        => $request->number,
            'issued_whom'   => $request->issuedWhom,
            'it_works_date' => isset($request->itWorksDate) ? Carbon::parse($request->itWorksDate) : null,
            'user_id'       => $user->id,
        ]);
        if (isset($request->file)) {
            $document->update([
                'url_view' => !empty($request->url) ? $request->url . $document->id : null
            ]);
        }
        return SuccessCreateDocumentResource::make(Document::find($document->id));
    }

    private function save($file): string
    {
        return $file->store('user/documents', 'local');
    }
}

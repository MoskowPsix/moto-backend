<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\CreateDocumentActionContract;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Models\Document;

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
            'name'      => $name,
            'type'      => $request->type,
            'path'      => $path ?? 'no-file',
            'data'      => json_encode($request->data, true),
            'user_id'   => $user->id,
        ]);
        return SuccessCreateDocumentResource::make($document);
    }

    private function save($file): string
    {
        return $file->store('user/documents', 'local');
    }
}

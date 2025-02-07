<?php

namespace App\Actions\Document;

use App\Contracts\Actions\Document\CreateDocumentActionContract;
use App\Http\Requests\Document\CreateDocumentRequest;
use App\Http\Resources\Document\Create\SuccessCreateDocumentResource;
use App\Models\Document;
use function MongoDB\BSON\toJSON;

class CreateDocumentAction implements CreateDocumentActionContract
{
    public function __invoke(CreateDocumentRequest $request): SuccessCreateDocumentResource
    {
        $path = $this->save($request->file);
        $name = uniqid('file_');
        $user = auth()->user();
        $document = Document::create([
            'name'      => $name,
            'type'      => $request->type,
            'path'      => $path,
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

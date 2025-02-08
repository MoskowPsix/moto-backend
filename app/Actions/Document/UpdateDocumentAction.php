<?php

namespace App\Actions\Document;

use App\Contracts\Actions\Document\UpdateDocumentActionContract;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Resources\Document\Update\SuccessUpdateDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Document;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UpdateDocumentAction implements UpdateDocumentActionContract
{
    public function __invoke(int $id, UpdateDocumentRequest $request): SuccessUpdateDocumentResource|NotFoundResource|NotUserPermissionResource
    {
        $user = auth()->user();
        $document = $user->documents()->where('id', $id);
        if (!$document->exists()) {
            return NotFoundResource::make([]);
        }
        if ($document->first()->user_id !== $user->id) {
            return NotUserPermissionResource::make([]);
        }

        if (isset($request->file)) {
            $this->delete($document->first()->path);
            $this->updateFile($request->file, $document);
        }

        if ($request->data) {
            $this->updateFields($request->data, Document::find($id));
        }

        return SuccessUpdateDocumentResource::make(Document::find($id));
    }

    private function updateFields($data, $document): void
    {
        $document->update([
            'data' => json_encode($data),
        ]);
    }
    private function updateFile($file, $document): void
    {
        $new_path = $this->save($file);
        $document->update([
            'name' => uniqid('file_'),
            'path' => $new_path,
        ]);
    }
    private function save($file): string
    {
        return $file->store('user/documents', 'local');
    }
    private function delete($path): string
    {
        return Storage::delete($path);
    }
}

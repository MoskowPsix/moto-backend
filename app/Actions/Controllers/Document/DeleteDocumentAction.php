<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\DeleteDocumentActionContract;
use App\Http\Resources\Document\Delete\SuccessDeleteDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use Illuminate\Support\Facades\Storage;

class DeleteDocumentAction implements DeleteDocumentActionContract
{

    public function __invoke(int $id): SuccessDeleteDocumentResource|NotFoundResource|NotUserPermissionResource
    {
        $user = auth()->user();
        $document = $user->documents()->where('id', $id);
        if (!$document->exists()) {
            return NotFoundResource::make([]);
        }
        if ($document->first()->user_id !== $user->id()) {
            return NotUserPermissionResource::make([]);
        }
        $path = $document->first()->path;
        $document->delete();
        $this->delete($path);
        return SuccessDeleteDocumentResource::make([]);
    }
    private function delete($path): void
    {
        Storage::delete($path);
    }
}

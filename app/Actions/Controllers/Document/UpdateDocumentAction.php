<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\UpdateDocumentActionContract;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Resources\Document\Update\SuccessUpdateDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Document;
use Carbon\Carbon;
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

        if (isset($request->file)) {
            $this->delete($document->first()->path);
            $this->updateFile($request, $document);
        }

        $this->updateFields($request, Document::find($id));

        return SuccessUpdateDocumentResource::make(Document::find($id));
    }

    private function updateFields($request, $document): void
    {
        $document->update([
            'type'          => $request->type ?? $document->type,
            'number'        => $request->number ?? $document->number,
            'issued_whom'   => $request->issuedWhom ?? $document->issued_whom,
            'it_works_date' => isset($request->itWorksDate) ? Carbon::parse($request->itWorksDate)->format('d.m.y') : $document->it_works_date,
        ]);
    }
    private function updateFile($request, $document): void
    {
        $new_path = $this->save($request->file);
        $document->update([
            'name' => uniqid('file_'),
            'path' => $new_path,
        ]);
    }
    private function save($file): string
    {
        return $file->store('user/documents', 'local');
    }
    private function delete($path): void
    {
        if (isset($path)) {
            Storage::delete($path);
        }
    }
}

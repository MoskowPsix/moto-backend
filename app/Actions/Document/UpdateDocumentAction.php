<?php

namespace App\Actions\Document;

use App\Contracts\Actions\Document\UpdateDocumentActionContract;
use App\Http\Requests\Document\UpdateDocumentRequest;
use App\Http\Resources\Document\Update\SuccessUpdateDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
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

//        DB::beginTransaction();
//        try{
//
//            $old_path = $document->first()->path;
            if ($request->data) {
                $this->updateFields($request->data, $document);
            }
//            if (isset($request->file)) {
//                $this->updateFile($request->file, $document);
//            }
//            $this->delete($old_path);
//            DB::commit();
//        } catch (\Exception $e) {
//            DB::rollBack();
//            dd($e);
//        }
        return SuccessUpdateDocumentResource::make($user->documents()->where('id', $id)->first());
    }

    private function updateFields($data, $document): void
    {
        $document->update([
            'data' => $data,
        ]);
    }
    private function updateFile($file, $document)
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

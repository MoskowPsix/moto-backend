<?php

namespace App\Actions\Controllers\Race;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Race\AddDocumentRaceActionContract;
use App\Http\Requests\Race\AddDocumentsRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\AddDocument\SuccessAddDocumentRaceResource;
use App\Models\Race;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Str;

class AddDocumentRaceAction implements AddDocumentRaceActionContract
{

    public function __invoke(int $id, AddDocumentsRaceRequest $request): SuccessAddDocumentRaceResource|NotFoundResource|NotUserPermissionResource
    {
        $race = Race::find($id);
        if (!$race) {
            return NotFoundResource::make([]);
        }
        $user = Auth::user();
        if (!$user->hasRole(RoleConstant::COMMISSION)) {
            return NotUserPermissionResource::make([]);
        }
        if(!isset($request->pdfFiles) && !isset($request->pdfFilesDel)){
            return SuccessAddDocumentRaceResource::make($race);
        }
        if(isset($request->pdfFiles)){
            $this->savePdfFile($request->pdfFiles, $race);
        }
        if(isset($request->pdfFilesDel)){
            $this->deletePdfFiles($request->pdfFilesDel, $race);
        }
        return SuccessAddDocumentRaceResource::make($race);
    }

    private function savePdfFile(array $pdfFies, Race $race): void
    {
        $currentFiles = $race->pdf_files ?? [];

        foreach ($pdfFies as $file) {
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $uniqueName = $originalName . '_' . uniqid() . '.' . $extension;
            $filePath = $file->storeAs('race/'.$race->id, $uniqueName, 'public');
            $currentFiles[] = $filePath;
        }

        $race->update([
            'pdf_files' => $currentFiles
        ]);
    }
    private function deletePdfFiles(array $filesToDelete, Race $race): void
    {
        $currentFiles = $race->pdf_files ?? [];

        foreach ($filesToDelete as $filePath) {
            $currentFiles = collect($currentFiles)
                ->filter(fn ($file) => $file !== $filePath)
                ->values()
                ->toArray();

            $this->deleteFile($filePath);
        }

        $race->update([
            'pdf_files' => $currentFiles
        ]);
    }
    private function deleteFile(string $filePath): void
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
        else {
            return;
        }
    }
}

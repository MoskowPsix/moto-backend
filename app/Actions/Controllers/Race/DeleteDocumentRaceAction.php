<?php

namespace App\Actions\Controllers\Race;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Race\DeleteDocumentRaceActionContract;
use App\Http\Requests\Race\DeleteDocumentsRaceRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Race\DeleteDocument\SuccessDeleteDocumentRaceResource;
use App\Models\Race;
use Illuminate\Support\Facades\Storage;

class DeleteDocumentRaceAction implements DeleteDocumentRaceActionContract
{

    public function __invoke(int $id, DeleteDocumentsRaceRequest $request): SuccessDeleteDocumentRaceResource|NotFoundResource|NotUserPermissionResource
    {
        $race = Race::find($id);
        if(!$race){
            return NotFoundResource::make([]);
        }
        $user = \Auth::user();
        if(!$user->hasRole(RoleConstant::COMMISSION)){
            return NotUserPermissionResource::make([]);
        }
        if(empty($race->pdf_files)){
            return NotFoundResource::make([]);
        }

        $this->deleteFiles($request->pdfFilesDel, $race);

        return SuccessDeleteDocumentRaceResource::make($race);
    }
    private function deleteFiles(array $files, Race $race): void
    {
        foreach ($files as $filePath) {
            // Удаляем файл из массива pdf_files
            $race->update([
                'pdf_files' => collect($race->pdf_files)
                    ->filter(fn ($file) => $file !== $filePath)
                    ->values()
                    ->toArray(),
            ]);

            // Удаляем файл с диска
            $this->deleteFile($filePath);
        }
    }
    private function deleteFile(string $filePath): void
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        } else {
            \Log::warning("Файл не найден в хранилище: {$filePath}");
        }
    }
}

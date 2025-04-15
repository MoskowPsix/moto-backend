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
        $this->savePdfFile($request, $race);
        return SuccessAddDocumentRaceResource::make($race);
    }

    private function savePdfFile(AddDocumentsRaceRequest $request, Race $race): void
    {
        if ($race->pdf_files) {
            $this->deleteFile($race->pdf_files);
        }

        // Сохраняем новый файл
        if ($request->hasFile('pdfFiles')) {
            $filePath = $request->file('pdfFiles')->store("race/{$race->id}", 'public');
            $race->update(['pdf_files' => $filePath]);
        }
    }

    private function deleteFile(string $filePath): void
    {
        Storage::disk('public')->delete($filePath);
    }
}

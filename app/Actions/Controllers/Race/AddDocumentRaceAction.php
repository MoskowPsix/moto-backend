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
        if(isset($request->pdfFiles)){
            $this->savePdfFile($request->pdfFiles, $race);
        }

        return SuccessAddDocumentRaceResource::make($race);
    }

    private function savePdfFile(array $pdfFies, Race $race): void
    {
        $currentFiles = $race->pdf_files ?? [];

        foreach ($pdfFies as $file) {
            $originalName = $file->getClientOriginalName();
            $filePath = $file->storeAs('race/'.$race->id, $originalName, 'public');
            $currentFiles[] = $filePath;
        }

        $race->update([
            'pdf_files' => $currentFiles
        ]);
    }
}

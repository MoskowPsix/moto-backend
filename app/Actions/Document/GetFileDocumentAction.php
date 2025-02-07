<?php

namespace App\Actions\Document;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Document\GetFileDocumentActionContract;
use App\Http\Resources\Document\GetFile\SuccessGetFileDocumentResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Document;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GetFileDocumentAction implements GetFileDocumentActionContract
{
    private RoleConstant $roleConstant;

    public function __construct()
    {
        $this->roleConstant = new RoleConstant();
    }

    public function __invoke(int $id): NotFoundResource|NotUserPermissionResource|\Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $user = auth()->user();
        $document = Document::where('id', $id);
        if (!$document->exists()) {
            return NotFoundResource::make([]);
        }
        if (!($document->first()->user_id === $user->id || $user->hasRole($this->roleConstant::ADMIN) || $user->hasRole($this->roleConstant::ROOT))) {
            return NotUserPermissionResource::make([]);
        }
        $file_path =Storage::drive('local')->path($document->first()->path);
        return response()->file($file_path);
    }
}

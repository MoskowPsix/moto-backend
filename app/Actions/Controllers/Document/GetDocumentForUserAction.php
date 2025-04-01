<?php

namespace App\Actions\Controllers\Document;

use App\Contracts\Actions\Controllers\Document\GetDocumentForUserActionContract;
use App\Http\Requests\Document\GetDocumentForUserRequest;
use App\Http\Resources\Document\GetForUser\SuccessGetDocumentForUserResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;

class GetDocumentForUserAction implements  GetDocumentForUserActionContract
{
    public function __invoke(GetDocumentForUserRequest $request): SuccessGetDocumentForUserResource|NotUserPermissionResource
    {
        if ($request->has('userId') && $request->has('commandId')) {
            $command = Command::find($request->commandId);

            if (!$command) {
                return NotUserPermissionResource::make([]);
            }

            $member = $command->members()->where('user_id', $request->userId)->first();
            if (!$member) {
                return NotUserPermissionResource::make([]);
            }
            $docs = $member->documents()->get();
        } else {
            $docs = auth()->user()->documents()->get();
        }
        return SuccessGetDocumentForUserResource::make($docs);
    }
}

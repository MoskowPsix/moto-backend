<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\DeleteCommandActionContract;
use App\Http\Resources\Command\Delete\SuccessDeleteCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;

class DeleteCommandAction implements DeleteCommandActionContract
{

    public function __invoke(int $id): SuccessDeleteCommandResource|NotFoundResource|NotUserPermissionResource
    {
        $command = Command::find($id);
        if(!isset($command)) {
            return NotFoundResource::make([]);
        }
        if($command->user_id !== auth()->user()->id){
            return NotUserPermissionResource::make([]);
        }
        $command->delete();
        return SuccessDeleteCommandResource::make($command);
    }
}

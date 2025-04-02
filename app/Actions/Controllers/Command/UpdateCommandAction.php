<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\UpdateCommandActionContract;
use App\Http\Requests\Command\UpdateCommandRequest;
use App\Http\Resources\Command\Update\SuccessUpdateCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use Illuminate\Support\Facades\Storage;

class UpdateCommandAction implements UpdateCommandActionContract
{

    public function __invoke(int $id, UpdateCommandRequest $request): SuccessUpdateCommandResource|NotFoundResource|NotUserPermissionResource
    {
        $command = Command::find($id);

        if (empty($command)) {
            return new NotFoundResource([]);
        }
        if ($command->user_id !== auth()->user()->id) {
            return NotUserPermissionResource::make([]);
        }
        $command->update([
            'name'          => $request->name ?? $command->name,
            'fullName'      => $request->fullname ?? $command->fullname,
            'coach'         => $request->coach ?? $command->coach,
            'city'          => $request->city ?? $command->city,
            'location_id'   => $request->locationId ?? $command->location_id,
        ]);
        $this->addNewAvatar($request, $command);

        return SuccessUpdateCommandResource::make($command);
    }

    private function addNewAvatar(UpdateCommandRequest $request, Command $command): void
    {
        if(!empty($request->avatar)){
            $this->saveAvatar($request->avatar, $command);
        }
    }

    private function saveAvatar($avatar, Command $command): void
    {
        $path = $command->avatar;

        if($command->avatar){
            $this->deleteAvatar($command->avatar);
        }
        if($avatar){
            $path = $avatar->store('command/'.$command->id, 'public');
        }
        $command->update([
            'avatar' => $path,
        ]);
    }
    private function deleteAvatar($path): void
    {
        Storage::delete($path);
    }
}

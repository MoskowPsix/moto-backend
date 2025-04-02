<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\CreateCommandActionContract;
use App\Http\Requests\Command\CreateCommandRequest;
use App\Http\Resources\Command\Create\SuccessCreateCommandResource;
use App\Models\Command;
use App\Models\Track;

class CreateCommandAction implements CreateCommandActionContract
{
    public function __invoke(CreateCommandRequest $request): SuccessCreateCommandResource
    {
        $user = auth()->user();
        $command = Command::create([
            'name'          => $request->name,
            'full_name'     => $request->fullname,
            'coach'         => $request->coach,
            'user_id'       => $user->id,
            'location_id'   => $request->locationId,
            'city'          => $request->city
        ]);
        $command->coaches()->attach($user->id);
        if(isset($request->avatar)) {
            $this->saveImages($request->avatar, $command);
        }
        return SuccessCreateCommandResource::make($command);
    }

    private function saveImages($avatar, Command $command): void
    {
        $path = $avatar->store('command/' . $command->id, 'public');
        $command->update(['avatar' => $path]);
    }
}

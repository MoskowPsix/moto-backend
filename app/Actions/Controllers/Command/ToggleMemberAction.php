<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\ToggleMemberActionContract;
use App\Http\Resources\Command\ToggleMember\SuccessToggleMemberCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;

class ToggleMemberAction implements ToggleMemberActionContract
{
    public function __invoke(int $command_id): NotFoundResource|SuccessToggleMemberCommandResource
    {
        $command = Command::where('id', $command_id);
        if (!$command->exists()) {
            return NotFoundResource::make([]);
        }
        $result = $command->first()->members()->toggle(auth()->user()->id);
        return SuccessToggleMemberCommandResource::make(!empty($result['attached']));
    }
}

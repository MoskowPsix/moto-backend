<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Resources\Command\ToggleMember\SuccessToggleMemberCommandResource;
use App\Http\Resources\Errors\NotFoundResource;

interface ToggleMemberActionContract
{
    public function __invoke(int $command_id): NotFoundResource|SuccessToggleMemberCommandResource;
}

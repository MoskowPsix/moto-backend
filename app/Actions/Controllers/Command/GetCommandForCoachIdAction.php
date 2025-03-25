<?php

namespace App\Actions\Controllers\Command;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Command\GetCommandForCoachIdActionContract;
use App\Http\Requests\Command\GetForCoachIdCommandRequest;
use App\Http\Resources\Command\GetCommandForCoach\SuccessGetCommandForCoachIdResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use App\Models\User;

class GetCommandForCoachIdAction implements GetCommandForCoachIdActionContract
{

    public function __invoke(GetForCoachIdCommandRequest $request): SuccessGetCommandForCoachIdResource|NotFoundResource|NotUserPermissionResource
    {
        $user = auth()->user();
        $commands = Command::whereHas('coaches', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
        return SuccessGetCommandForCoachIdResource::make($commands);
    }
}

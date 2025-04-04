<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\GetForIdCommandActionContract;
use App\Http\Requests\Command\GetForIdCommandRequest;
use App\Http\Resources\Command\GetCommandForId\SuccessGetCommandForIdResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;

class GetForIdCommandAction implements GetForIdCommandActionContract
{

    public function __invoke(int $id, GetForIdCommandRequest $request): SuccessGetCommandForIdResource|NotFoundResource
    {
        $command = Command::with('location')->where('id', $id);

        if ($request->has('userIdExists') && $request->has('checkMember')) {
            $userId = $request->get('userIdExists');

            $command->withExists(['members' => function ($q) use ($userId) {
                $q->where('user_id', $userId);
            }]);
        }
        if (!$command->exists())
            return NotFoundResource::make([]);
        return SuccessGetCommandForIdResource::make($command->first());
    }
}

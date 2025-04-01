<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\GetCoachesForAllUsersActionContract;
use App\Http\Requests\Command\GetCoachesForAllUsersRequest;
use App\Http\Resources\Command\GetCoachesForAll\SuccessGetCoachesForAllCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Pipeline\Pipeline;

class GetCoachesForAllUsersAction implements GetCoachesForAllUsersActionContract
{
    public function __invoke(int $id, GetCoachesForAllUsersRequest $request):
    SuccessGetCoachesForAllCommandResource|
    NotFoundResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $command = Command::where('id', $id);
        if (!$command->exists()) {
            return NotFoundResource::make([]);
        }
        $coaches_q = $command->first()->coaches();
        $coaches = app(Pipeline::class)
            ->send($coaches_q)
            ->through([

            ])
            ->via('apply')
            ->then(function ($commands) use ($page, $limit, $request) {
                return $request->paginate ?
                    $commands->simplePaginate($limit, ['*'], 'page', $page) :
                    $commands->get();
            });
        return SuccessGetCoachesForAllCommandResource::make($coaches);
    }
}

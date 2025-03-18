<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\GetCouchesActionContract;
use App\Filters\Command\CommandUserIdFilter;
use App\Filters\Command\NameCommandFilter;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetCouches\SuccessGetCouchesCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Pipeline\Pipeline;

class GetCouchesAction implements GetCouchesActionContract
{
    public function __invoke(int $id, GetCouchesCommandRequest $request):
    NotFoundResource|
    SuccessGetCouchesCommandResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $command = Command::where('id', $id);
        if (!$command->exists()) {
            return NotFoundResource::make([]);
        }
        $couches_q = $command->first()->coaches();
        $couches = app(Pipeline::class)
            ->send($couches_q)
            ->through([

            ])
            ->via('apply')
            ->then(function ($commands) use ($page, $limit, $request) {
                return $request->paginate ?
                    $commands->simplePaginate($limit, ['*'], 'page', $page) :
                    $commands->get();
            });
        return SuccessGetCouchesCommandResource::make($couches);
    }
}

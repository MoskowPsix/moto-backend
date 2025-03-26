<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\GetCommandActionContract;
use App\Filters\Command\CommandCoachExist;
use App\Filters\Command\CommandUserExist;
use App\Filters\Command\CommandUserIdFilter;
use App\Filters\Command\NameCommandFilter;
use App\Http\Requests\Command\GetCommandRequest;
use App\Http\Resources\Command\GetCommand\SuccessGetCommandResource;
use App\Models\Command;
use Illuminate\Pipeline\Pipeline;

class GetCommandAction implements GetCommandActionContract
{

    public function __invoke(GetCommandRequest $request): SuccessGetCommandResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $command_q = Command::with('location');
        $command = app(Pipeline::class)
            ->send($command_q)
            ->through([
                CommandUserIdFilter::class,
                NameCommandFilter::class,
                CommandUserExist::class,
//                CommandCoachExist::class,
            ])
            ->via('apply')
            ->then(function ($commands) use ($page, $limit, $request) {
                return $request->paginate ?
                    $commands->simplePaginate($limit, ['*'], 'page', $page) :
                    $commands->get();
            });
            return SuccessGetCommandResource::make($command);
    }
}

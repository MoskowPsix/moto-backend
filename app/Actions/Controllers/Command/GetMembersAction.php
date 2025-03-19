<?php

namespace App\Actions\Controllers\Command;

use App\Contracts\Actions\Controllers\Command\GetMembersActionContract;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetCouches\SuccessGetCouchesCommandResource;
use App\Http\Resources\Command\GetMember\SuccessGetMemberCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Models\Command;
use Illuminate\Pipeline\Pipeline;

class GetMembersAction implements GetMembersActionContract
{
    public function __invoke(int $id, GetCouchesCommandRequest $request):
    NotFoundResource|
    SuccessGetMemberCommandResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $command = Command::where('id', $id);
        if (!$command->exists()) {
            return NotFoundResource::make([]);
        }
        $members_q = $command->first()->members();
        $members = app(Pipeline::class)
            ->send($members_q)
            ->through([

            ])
            ->via('apply')
            ->then(function ($commands) use ($page, $limit, $request) {
                return $request->paginate ?
                    $commands->simplePaginate($limit, ['*'], 'page', $page) :
                    $commands->get();
            });
        return SuccessGetMemberCommandResource::make($members);
    }
}

<?php

namespace App\Actions\Controllers\Command;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\Command\GetMembersForCoachActionContract;
use App\Filters\Command\CommandMembersInRaceExist;
use App\Http\Requests\Command\GetCouchesCommandRequest;
use App\Http\Resources\Command\GetMember\SuccessGetMemberCommandResource;
use App\Http\Resources\Command\GetMembersForCoach\GetMembersForCoachCommandResource;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Models\Command;
use Illuminate\Pipeline\Pipeline;

class GetMembersForCoachAction implements GetMembersForCoachActionContract
{
    public function __invoke($id, GetCouchesCommandRequest $request):
    NotUserPermissionResource|
    NotFoundResource|
    GetMembersForCoachCommandResource
    {
        if (!Command::where('id', $id)->exists()) {
            return NotFoundResource::make([]);
        }
        if (!Command::find($id)->coaches()->where('user_id', auth()->user()->id)->exists() && !auth()->user()->hasRole(RoleConstant::ROOT)) {
            return NotUserPermissionResource::make([]);
        }
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $command = Command::where('id', $id);
        $members_q = $command->first()->members()->with(['documents', 'personalInfo' => function ($query) {
            $query->with('location');
        }, 'phone']);
        $members = app(Pipeline::class)
            ->send($members_q)
            ->through([
                CommandMembersInRaceExist::class,
            ])
            ->via('apply')
            ->then(function ($commands) use ($page, $limit, $request) {
                return $request->paginate ?
                    $commands->simplePaginate($limit, ['*'], 'page', $page) :
                    $commands->get();
            });
        return GetMembersForCoachCommandResource::make($members);

    }
}

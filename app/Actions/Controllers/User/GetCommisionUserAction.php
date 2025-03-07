<?php

namespace App\Actions\Controllers\User;

use App\Constants\RoleConstant;
use App\Contracts\Actions\Controllers\User\GetCommisionUserActionContract;
use App\Http\Requests\User\GetCommisionUserRequest;
use App\Http\Resources\User\GetCommision\SuccessGetCommisionUserResource;
use App\Models\User;
use Illuminate\Pipeline\Pipeline;

class GetCommisionUserAction implements GetCommisionUserActionContract
{
    private RoleConstant $role;
    public function __invoke(GetCommisionUserRequest $request): SuccessGetCommisionUserResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $users_q = User::whereHas('roles', function ($q) {
            return $q->where('name', RoleConstant::COMMISSION);
        });

        $users = app(Pipeline::class)
            ->send($users_q)
            ->through([])
            ->via('apply')
            ->then(function ($races) use ($page, $limit, $request) {
                return $request->paginate ?
                    $races->orderBy('created_at', 'asc')->simplePaginate($limit, ['*'], 'page',  $page) :
                    $races->orderBy('created_at', 'asc')->get();
            });
        return SuccessGetCommisionUserResource::make($users);
    }
}

<?php

namespace App\Actions\Controllers\Race;

use App\Contracts\Actions\Controllers\Race\GetForIdRaceActionContract;
use App\Http\Requests\Race\GetForIdRaceRequest;
use App\Http\Resources\Race\GetRaceForId\SuccessGetRaceForIdResource;
use App\Models\Race;

class GetForIdRaceAction implements GetForIdRaceActionContract
{
    public function __invoke(int $id, GetForIdRaceRequest $request): SuccessGetRaceForIdResource
    {
        $race = Race::
//        with('track', 'user', 'location', 'grades', 'status', 'favoritesCount', 'commissions', 'store')
            where('id', $id);
        if(request()->has('userId') && request()->has('appointmentUser')){
            $userId = request()->get('userId');
            $race->withExists(['appointments' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }
        if(request()->has('userId') && request()->has('favouritesUser')){
            $userId = request()->get('userId');
            $race->withExists(['favouritesUser' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }
        if(request()->has('userIdExists') && request()->has('commissionUser')){
            $userId = request()->get('userIdExists');
            $race->withExists(['commissions' => function($q) use ($userId){
                $q->where('user_id', $userId);
            }]);
        }
        if(request()->has('userId') && request()->has('transactionUser')){
            $userId = request()->get('userId');
            $race->withExists(['attendance' => function($q) use ($userId) {
                $q->whereHas('transactions', function($q) use ($userId){
                    $q->where('status', true)->where('user_id', $userId);
                });
            }]);
        }

        return SuccessGetRaceForIdResource::make($race->first());
    }
}

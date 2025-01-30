<?php

namespace App\Actions\Race;

use App\Contracts\Actions\Race\GetRaceActionContract;
use App\Filters\Race\RaceAppointmentExists;
use App\Filters\Race\RaceForTrackFilter;
use App\Filters\Race\RaceUserIdFilter;
use App\Http\Requests\Race\GetRaceRequest;
use App\Http\Resources\Race\GetRaces\SuccessGetRaceResource;
use App\Models\Race;
use Illuminate\Pipeline\Pipeline;

class GetRaceAction implements GetRaceActionContract
{
    public function __invoke(GetRaceRequest $request): SuccessGetRaceResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $races_q = Race::with('track', 'user', 'appointmentCount');
        $races = app(Pipeline::class)
            ->send($races_q)
            ->through([
                RaceUserIdFilter::class,
                RaceAppointmentExists::class,
                RaceForTrackFilter::class,
            ])
            ->via('apply')
            ->then(function ($races) use ($page, $limit, $request) {
                return $request->paginate ?
                    $races->orderBy('date_start', 'desc')->simplePaginate($limit, ['*'], 'page',  $page) :
                    $races->orderBy('date_start', 'desc')->get();
            });
        return SuccessGetRaceResource::make($races);
    }
}

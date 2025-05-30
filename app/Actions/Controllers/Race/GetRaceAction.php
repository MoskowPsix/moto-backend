<?php

namespace App\Actions\Controllers\Race;

use App\Contracts\Actions\Controllers\Race\GetRaceActionContract;
use App\Filters\Race\FavoriteExistsFilter;
use App\Filters\Race\RaceAppointmentExists;
use App\Filters\Race\RaceDateFilter;
use App\Filters\Race\RaceForDegreeFilter;
use App\Filters\Race\RaceForLocationIdsFilter;
use App\Filters\Race\RaceForStatusFilter;
use App\Filters\Race\RaceForTrackFilter;
use App\Filters\Race\RaceNameFilter;
use App\Filters\Race\RaceSortFilter;
use App\Filters\Race\RaceUserCommissionExistsFilter;
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

        $races_q = Race::with('track', 'user', 'appointmentCount', 'grades', 'status', 'favoritesCount', 'store');
        $races = app(Pipeline::class)
            ->send($races_q)
            ->through([
                RaceDateFilter::class,
                RaceUserIdFilter::class,
                RaceAppointmentExists::class,
                RaceForTrackFilter::class,
                RaceForLocationIdsFilter::class,
                RaceForStatusFilter::class,
                RaceSortFilter::class,
                FavoriteExistsFilter::class,
                RaceUserCommissionExistsFilter::class,
                RaceNameFilter::class,
                RaceForDegreeFilter::class,
            ])
            ->via('apply')
            ->then(function ($races) use ($page, $limit, $request) {
                return $request->paginate ?
                    $races->simplePaginate($limit, ['*'], 'page',  $page) :
                    $races->get();
            });
        return SuccessGetRaceResource::make($races);
    }
}

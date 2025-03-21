<?php

namespace App\Actions\Controllers\Location;

use App\Contracts\Actions\Controllers\Location\GetLocationActionContract;
use App\Filters\Location\LocationExistsCountRaceFilter;
use App\Filters\Location\LocationExistsCountTrackFilter;
use App\Filters\Location\LocationForNameFilter;
use App\Http\Requests\Location\GetLocationRequest;
use App\Http\Resources\Location\LocationResource\SuccessGetLocationResource;
use App\Models\Location;
use Illuminate\Pipeline\Pipeline;


class GetLocationAction implements  GetLocationActionContract
{

    public function __invoke(GetLocationRequest $request): SuccessGetLocationResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $locations_q = Location::query();
        $locations = app(Pipeline::class)
            ->send($locations_q)
            ->through([
                LocationExistsCountTrackFilter::class,
//                LocationExistsCountRaceFilter::class,
                LocationForNameFilter::class
            ])
            ->via('apply')
            ->then(function ($races) use ($page, $limit, $request) {
                return $request->paginate ?
                    $races->orderBy('name', 'asc')->simplePaginate($limit, ['*'], 'page',  $page) :
                    $races->orderBy('name', 'asc')->get();
            });
        return SuccessGetLocationResource::make($locations);
    }
}

<?php

namespace App\Actions\Controllers\Track;

use App\Contracts\Actions\Controllers\Track\GetTracksActionContract;
use App\Filters\Race\RaceForLocationIdsFilter;
use App\Filters\Race\RaceNameFilter;
use App\Filters\Track\TrackForLocationIdsFilter;
use App\Filters\Track\TrackStoreExists;
use App\Filters\Track\TrackUserIdFilter;
use App\Http\Requests\Track\GetTracksRequest;
use App\Http\Resources\Track\GetTracks\SuccessGetTracksResource;
use App\Models\Track;
use Illuminate\Pipeline\Pipeline;


class GetTracksAction implements GetTracksActionContract
{
    public function __invoke(GetTracksRequest $request): SuccessGetTracksResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $track_q = Track::selectRaw(
            '*, ' . (config('database.default') === 'sqlite' ? 'point' : 'ST_AsGeoJSON(point) as point')
        )->with('level', 'location');
        $tracks = app(Pipeline::class)
            ->send($track_q)
            ->through([
                TrackUserIdFilter::class,
                TrackForLocationIdsFilter::class,
                TrackStoreExists::class,
                RaceNameFilter::class,
            ])
            ->via('apply')
            ->then(function ($tracks) use ($page, $limit, $request) {
                return $request->paginate ?
                    $tracks->simplePaginate($limit, ['*'], 'page',  $page) :
                    $tracks->get();
            });
        return SuccessGetTracksResource::make($tracks);
    }
}

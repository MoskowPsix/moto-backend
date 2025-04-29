<?php

namespace App\Actions\Controllers\RaceResult;

use App\Contracts\Actions\Controllers\RaceResult\GetResultsActionContract;
use App\Http\Requests\RaceResult\GetRaceResultsRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\RaceResult\Get\SuccessGetRaceResultsResource;
use App\Models\Race;
use App\Models\RaceResult;
use Illuminate\Pipeline\Pipeline;

class GetResultsAction implements GetResultsActionContract
{
    public function __invoke(int $id, GetRaceResultsRequest $request):
    SuccessGetRaceResultsResource|
    NotFoundResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        if (!Race::where('id', $id)->exists()) {
            return NotFoundResource::make([]);
        }

        $result_q = RaceResult::where('race_id', $id)->with('user', 'race', 'command', 'cup');
        $result = app(Pipeline::class)
            ->send($result_q)
            ->through([])
            ->via('apply')
            ->then(function ($result) use ($page, $limit, $request) {
                return $request->paginate ?
                    $result->simplePaginate($limit, ['*'], 'page',  $page) :
                    $result->get();
            });
        return SuccessGetRaceResultsResource::make($result);
    }
}

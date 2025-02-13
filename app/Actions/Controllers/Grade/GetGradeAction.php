<?php

namespace App\Actions\Controllers\Grade;

use App\Contracts\Actions\Controllers\Grade\GetGradeActionContract;
use App\Filters\Grade\GradeUserIdFilter;
use App\Http\Requests\Grade\GetGradeRequest;
use App\Http\Resources\Grade\GetGrade\SuccessGetGradeResource;
use App\Models\Grade;
use Illuminate\Pipeline\Pipeline;

class GetGradeAction implements GetGradeActionContract
{
    public function __invoke(GetGradeRequest $request): SuccessGetGradeResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        $grades_q = Grade::query();
        $grades = app(Pipeline::class)
            ->send($grades_q)
            ->through([
                GradeUserIdFilter::class,
            ])
            ->via('apply')
            ->then(function ($grades) use ($page, $limit, $request) {
                return $request->paginate ?
                    $grades->simplePaginate($limit, ['*'], 'page', $page) :
                    $grades->get();
            });

        return SuccessGetGradeResource::make($grades);
    }
}

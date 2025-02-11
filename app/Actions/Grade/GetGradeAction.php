<?php

namespace App\Actions\Grade;

use App\Contracts\Actions\Grade\GetGradeActionContract;
use App\Http\Requests\Grade\GetGradeRequest;
use App\Http\Resources\Grade\GetGrade\SuccessGetGradeResource;
use Illuminate\Pipeline\Pipeline;

class GetGradeAction implements GetGradeActionContract
{

    public function __invoke(GetGradeRequest $request): SuccessGetGradeResource
    {
        $page = $request->page;
        $limit = $request->limit && ($request->limit < 50) ? $request->limit : 6;

        return SuccessGetGradeResource();
    }
}

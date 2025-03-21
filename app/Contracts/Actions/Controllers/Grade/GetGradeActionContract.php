<?php

namespace App\Contracts\Actions\Controllers\Grade;

use App\Http\Requests\Grade\GetGradeRequest;
use App\Http\Resources\Grade\GetGrade\SuccessGetGradeResource;

interface GetGradeActionContract
{
    public function __invoke(GetGradeRequest $request): SuccessGetGradeResource;
}

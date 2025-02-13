<?php

namespace App\Contracts\Actions\Controllers\Grade;

use App\Http\Requests\Grade\GetForIdGradeRequest;
use App\Http\Resources\Grade\GetGradeForId\SuccessGetGradeForIdResource;

interface GetForIdGradeActionContract
{
    public function __invoke(int $id, GetForIdGradeRequest $request): SuccessGetGradeForIdResource;
}

<?php

namespace App\Contracts\Actions\Grade;

use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Http\Resources\Grade\Update\SuccessUpdateGradeResource;

interface UpdateGradeActionContract
{
    public function __invoke(int $id, UpdateGradeRequest $request): SuccessUpdateGradeResource;
}

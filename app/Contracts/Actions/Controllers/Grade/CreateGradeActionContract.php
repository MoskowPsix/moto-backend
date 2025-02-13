<?php

namespace App\Contracts\Actions\Controllers\Grade;

use App\Http\Requests\Grade\CreateGradeRequest;
use App\Http\Resources\Grade\Create\SuccessCreateGradeResource;

interface CreateGradeActionContract
{
    public function __invoke(CreateGradeRequest $request): SuccessCreateGradeResource;
}

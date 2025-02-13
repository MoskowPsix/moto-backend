<?php

namespace App\Actions\Controllers\Grade;

use App\Contracts\Actions\Controllers\Grade\GetForIdGradeActionContract;
use App\Http\Requests\Grade\GetForIdGradeRequest;
use App\Http\Resources\Grade\GetGradeForId\SuccessGetGradeForIdResource;
use App\Models\Grade;

class GetForIdGradeAction implements GetForIdGradeActionContract
{
    public function __invoke(int $id, GetForIdGradeRequest $request): SuccessGetGradeForIdResource
    {
        $grade = Grade::with('user')->where('id', $id);
        if($request->has('userId')){
            $userId = $request->get('userId');
            $grade->where('user_id', $userId);
        }
        return SuccessGetGradeForIdResource::make($grade->first());
    }
}

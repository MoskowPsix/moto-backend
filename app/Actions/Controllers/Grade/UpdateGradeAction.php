<?php

namespace App\Actions\Controllers\Grade;

use App\Contracts\Actions\Controllers\Grade\UpdateGradeActionContract;
use App\Http\Requests\Grade\UpdateGradeRequest;
use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Grade\Update\SuccessUpdateGradeResource;
use App\Models\Grade;

class UpdateGradeAction implements UpdateGradeActionContract
{
    public function __invoke(int $id, UpdateGradeRequest $request): SuccessUpdateGradeResource|NotFoundResource|NotUserPermissionResource
    {
        $grade = Grade::find($id);
        if(!$grade){
            return new NotFoundResource([]);
        }
        if(auth()->user()->id !== $grade->user_id){
            return NotUserPermissionResource::make([]);
        }
        $grade->update([
            'name' => $request->name ?? $grade->name,
            'description' => $request->description ?? $grade->description,
            'user_id' => $request->get('userId') ?? $grade->user_id,
        ]);
        return SuccessUpdateGradeResource::make($grade);
    }
}

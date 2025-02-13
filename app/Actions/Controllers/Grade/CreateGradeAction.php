<?php

namespace App\Actions\Controllers\Grade;

use App\Contracts\Actions\Controllers\Grade\CreateGradeActionContract;
use App\Http\Requests\Grade\CreateGradeRequest;
use App\Http\Resources\Grade\Create\SuccessCreateGradeResource;
use App\Models\Grade;

class CreateGradeAction implements CreateGradeActionContract
{
    public function __invoke(CreateGradeRequest $request): SuccessCreateGradeResource
    {
        $user = auth()->user();
        $grade = Grade::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' =>  $user->id,
        ]);
        return SuccessCreateGradeResource::make($grade);
    }
}

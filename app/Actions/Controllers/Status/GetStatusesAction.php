<?php

namespace App\Actions\Controllers\Status;

use App\Contracts\Actions\Controllers\Status\GetStatusesActionContract;
use App\Http\Resources\Status\GetStatuses\SuccessGetStatusesResource;
use App\Models\Status;

class GetStatusesAction implements GetStatusesActionContract
{
    public function __invoke(): SuccessGetStatusesResource
    {
        return SuccessGetStatusesResource::make(Status::all());
    }
}

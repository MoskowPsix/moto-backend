<?php

namespace App\Contracts\Actions\Controllers\Status;

use App\Http\Resources\Status\GetStatuses\SuccessGetStatusesResource;

interface GetStatusesActionContract
{
    public function __invoke(): SuccessGetStatusesResource;
}

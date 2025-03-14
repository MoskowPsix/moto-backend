<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Actions\Controllers\Status\GetStatusesActionContract;
use App\Http\Controllers\Controller;
use App\Http\Resources\Status\GetStatuses\SuccessGetStatusesResource;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function get(GetStatusesActionContract $action): SuccessGetStatusesResource
    {
        return $action();
    }
}

<?php

namespace App\Contracts\Actions\Controllers\Cup;

use App\Http\Requests\Cup\GetForIdCupRequest;
use App\Http\Resources\Cup\GetForId\SuccessGetForIdCupResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetForIdCupActionContract
{
    public function __invoke(int $id, GetForIdCupRequest $request): SuccessGetForIdCupResource|NotFoundResource;
}

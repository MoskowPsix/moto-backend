<?php

namespace App\Contracts\Actions\Controllers\Cup;

use App\Http\Requests\Cup\CreateCupRequest;
use App\Http\Resources\Cup\Create\SuccessCreateCupResource;

interface CreateCupActionContract
{
    public function __invoke(CreateCupRequest $request): SuccessCreateCupResource;
}

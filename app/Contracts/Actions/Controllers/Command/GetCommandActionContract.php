<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\GetCommandRequest;
use App\Http\Resources\Command\GetCommand\SuccessGetCommandResource;

interface GetCommandActionContract
{
    public function __invoke(GetCommandRequest $request): SuccessGetCommandResource;
}

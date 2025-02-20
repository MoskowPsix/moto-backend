<?php

namespace App\Contracts\Actions\Controllers\Command;

use App\Http\Requests\Command\CreateCommandRequest;
use App\Http\Resources\Command\Create\SuccessCreateCommandResource;

interface CreateCommandActionContract
{
    public function __invoke(CreateCommandRequest $request): SuccessCreateCommandResource;
}

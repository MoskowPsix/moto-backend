<?php

namespace App\Contracts\Actions\Controllers\Command;


use App\Http\Requests\Command\GetForIdCommandRequest;
use App\Http\Resources\Command\GetCommandForId\SuccessGetCommandForIdResource;
use App\Http\Resources\Errors\NotFoundResource;

interface GetForIdCommandActionContract
{
    public function __invoke(int $id, GetForIdCommandRequest $request): SuccessGetCommandForIdResource|NotFoundResource;
}

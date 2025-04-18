<?php

namespace App\Contracts\Actions\Controllers\User;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\User\GetForId\SuccessUserGetForIdResource;

interface GetUserForIdActionContract
{
    public function __invoke(int $id): SuccessUserGetForIdResource | NotFoundResource;
}

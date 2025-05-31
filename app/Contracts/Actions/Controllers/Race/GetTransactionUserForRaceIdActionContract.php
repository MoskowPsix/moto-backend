<?php

namespace App\Contracts\Actions\Controllers\Race;

use App\Http\Resources\Race\GetTransactionUserForRaceId\SuccessGetTransactionUserForRaceIdResource;

interface GetTransactionUserForRaceIdActionContract
{
    public function __invoke(int $id): SuccessGetTransactionUserForRaceIdResource;
}

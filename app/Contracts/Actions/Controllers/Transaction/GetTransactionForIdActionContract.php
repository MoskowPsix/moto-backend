<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Resources\Errors\NotFoundResource;
use App\Http\Resources\Errors\NotUserPermissionResource;
use App\Http\Resources\Transaction\GetForId\SuccessGetTransactionForIdResource;

interface GetTransactionForIdActionContract
{
    public function __invoke(int $id):
    NotFoundResource|
    NotUserPermissionResource|
    SuccessGetTransactionForIdResource;
}

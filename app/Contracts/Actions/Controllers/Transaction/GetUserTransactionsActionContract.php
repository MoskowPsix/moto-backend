<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\User\GetUserTransactionsRequest;
use App\Http\Resources\Transaction\GetTransactions\SuccessGetUserTransactionsResource;

interface GetUserTransactionsActionContract
{
    public function __invoke(GetUserTransactionsRequest $request): SuccessGetUserTransactionsResource;
}

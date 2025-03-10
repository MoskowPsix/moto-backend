<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\Transaction\FailedTransactionRequest;
use App\Http\Resources\Transaction\FailedTransaction\FailedTransactionResource;

interface FailedTransactionActionContract
{
    public function __invoke(FailedTransactionRequest $request): FailedTransactionResource;
}

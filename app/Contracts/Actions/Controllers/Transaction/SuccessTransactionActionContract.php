<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\Transaction\SuccessTransactionRequest;
use App\Http\Resources\Transaction\SuccessTransaction\SuccessTransactionResource;

interface SuccessTransactionActionContract
{
    public function __invoke(SuccessTransactionRequest $request): SuccessTransactionResource;
}

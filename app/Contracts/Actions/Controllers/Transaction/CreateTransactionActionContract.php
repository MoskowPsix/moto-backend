<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\Transaction\CreateTransactionRequest;
use App\Http\Resources\Transaction\Create\SuccessCreateTransactionResource;

interface CreateTransactionActionContract
{
    public function __invoke(CreateTransactionRequest $request): SuccessCreateTransactionResource;
}

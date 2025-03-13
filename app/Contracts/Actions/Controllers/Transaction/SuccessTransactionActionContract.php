<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\Transaction\SuccessTransactionRequest;
use App\Http\Resources\Transaction\SuccessTransaction\SuccessTransactionResource;
use Illuminate\Http\Request;

interface SuccessTransactionActionContract
{
    public function __invoke(Request $request);
}

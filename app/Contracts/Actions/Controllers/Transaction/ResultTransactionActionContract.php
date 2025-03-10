<?php

namespace App\Contracts\Actions\Controllers\Transaction;

use App\Http\Requests\Transaction\ResultTransactionRequest;
use Illuminate\Http\Request;

interface ResultTransactionActionContract
{
    public function handleResult(Request $request);
}

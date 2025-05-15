<?php

namespace App\Contracts\Services;

use App\Models\Transaction;

interface SecondCheckServiceContract
{
    public function send(Transaction $transaction): array;
}

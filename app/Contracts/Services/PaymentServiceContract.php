<?php

namespace App\Contracts\Services;

use App\Models\Transaction;

interface PaymentServiceContract
{
    public function generateLink(Transaction $transaction): string;
    public function generateLinkWithSaveCard(Transaction $transaction, string $opKey): string;
}

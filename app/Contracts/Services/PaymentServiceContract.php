<?php

namespace App\Contracts\Services;

use App\Models\Transaction;

interface PaymentServiceContract
{
//    public function generateLink(Transaction $transaction, $store, $attendance): string;
    public function generateLinkForRace(Transaction $transaction): string;
    public function generateLinkForTrack(Transaction $transaction): string;
}

<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer    $id
 * @property string     $desc
 * @property integer    $user
 * @property string     $date
 * @property array      $attendance
 */

class ShortTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'desc'          => $this->desc,
            'date'          => $this->date,
        ];
    }
}

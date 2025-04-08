<?php

namespace App\Http\Resources\Document\VerifyDocsForCommission;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessVerifyDocsForCommissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => 'success',
            'message' => __('messages.document.verify_docs_for_commission.success')
        ];
    }
}

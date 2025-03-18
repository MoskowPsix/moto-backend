<?php

namespace App\Http\Resources\Command\AddCouch;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessAddCouchCommandResource extends JsonResource
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
            'message' => __('messages.command.add_couch.success', ['is_attach' => $this->resource ? 'добавлен' : 'удалён']),
        ];
    }
}

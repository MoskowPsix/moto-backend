<?php

namespace App\Http\Resources\Command\ToggleMember;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessToggleMemberCommandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status'    => 'success',
            'message'   => __('messages.command.member_toggle.success', ['is_attach' => $this->resource ? 'добавлен' : 'удалён']),
        ];
    }
}

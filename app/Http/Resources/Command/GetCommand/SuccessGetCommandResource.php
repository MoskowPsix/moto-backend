<?php
namespace App\Http\Resources\Command\GetCommand;
use App\Http\Resources\Command\CommandResource;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SuccessGetCommandResource extends JsonResource
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
            'message'   => __('messages.command.get.success'),
            'commands'     => $this->resource instanceof Command ? CommandResource::make($this->resource) : CommandResource::collection($this->resource),
        ];
    }
}

<?php

namespace App\Http\Resources\Document;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string $path
 * @property string $data
 * @property mixed $view_url
 * @property mixed $number
 * @property mixed $issued_whom
 * @property mixed $it_works_date
 * @property mixed $is_checked
 * @property mixed $url_view
 */
class DocumentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'type'              => $this->type,
            'url_view'          => $this->url_view,
            'number'            => $this->number,
            'issued_whom'       => $this->issued_whom,
            'it_works_date'     => $this->it_works_date,
            'is_checked'        => $this->is_checked,
        ];
    }
}

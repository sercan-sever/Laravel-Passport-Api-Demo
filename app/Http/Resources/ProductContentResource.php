<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Number;

class ProductContentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'shortStatement' => $this->short_statement,
            'statement' => $this->statement,
            'price' => Number::currency(number: $this->price, in: 'TRY', locale: 'tr'),
            'image' => $this->getImage(),
            'type' => $this->type,
        ];
    }
}

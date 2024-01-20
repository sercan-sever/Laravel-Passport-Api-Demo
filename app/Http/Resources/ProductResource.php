<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'user' => UserResource::make($this->user),
            'name' => $this->name,
            'slug' => $this->slug,
            'content' => ProductContentResource::make($this->content),
            'status' => [
                'name' => $this->status->title(),
                'value' => $this->status,
            ],
        ];
    }
}

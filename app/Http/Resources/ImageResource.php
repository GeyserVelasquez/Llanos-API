<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            'name' => $this->name,
            'path' => $this->path,
            'description' => $this->description,
            'livestock_id' => $this->livestock_id,
            'livestock' => new LivestockResource($this->whenLoaded('livestock')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

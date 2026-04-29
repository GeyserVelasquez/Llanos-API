<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BatchMovementResource extends JsonResource
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
            'batch_id' => $this->batch_id,
            'livestock_id' => $this->livestock_id,
            'made_at' => $this->made_at->format('Y-m-d'),
            'attributes' => $this->attributes,
            'batch' => new BatchResource($this->whenLoaded('batch')),
            'livestock' => new LivestockResource($this->whenLoaded('livestock')),
        ];
    }
}

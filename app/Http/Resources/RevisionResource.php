<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RevisionResource extends JsonResource
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
            'livestock_id' => $this->livestock_id,
            'made_at' => $this->made_at->format('Y-m-d'),
            'revision_result' => $this->revision_result,
            'revision_type_id' => $this->revision_type_id,
            'technique_id' => $this->technique_id,
            'livestock' => new LivestockResource($this->whenLoaded('livestock')),
            'revision_type' => new RevisionTypeResource($this->whenLoaded('revisionType')),
            'technique' => new TechniqueResource($this->whenLoaded('technique')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // 'category:id,name', 'user:id,name', 'tags', 'proposals'
        return [
            'id' => $this->id,
            'title' => $this->title,
            // 'category_name' => $this->category->name,
            // 'category' => $this->category ? new CategoryResource($this->category) : null,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'description' => $this->description,
            'update_time' => $this->updated_at,
            'status' => $this->status,
            'tags' => TagsResource::collection($this->tags),
            '_links' => [
                '_self' => url('api/projects/' . $this->id)
            ]
        ];
    }
}

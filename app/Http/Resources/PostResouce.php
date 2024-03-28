<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResouce extends JsonResource
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
            'user' => new UserResource($this->user),
            'name' => $this->name,
            'category_id' => $this->category_id,
            'category' => new CategoryResource($this->category),
            'slug' => $this->slug,
            'content' => $this->content,
            'tags' => $this->tags,
            'image_url' => $this->image
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'role' => $this->role,
            'company' => $this->company,
            'content' => $this->content,
            'rating' => $this->rating,
            'project' => $this->project,
            'project_id' => $this->project_id,
            'image' => $this->image,
            'featured' => $this->featured,
            'published' => $this->published,
            'sort_order' => $this->sort_order,
            'verified' => $this->verified,
            'portfolio' => $this->whenLoaded('portfolio', function () {
                return [
                    'id' => $this->portfolio->id,
                    'title' => $this->portfolio->title,
                    'slug' => $this->portfolio->slug,
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}

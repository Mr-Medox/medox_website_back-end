<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PortfolioResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'content' => $this->content,
            'featured_image' => $this->featured_image,
            'gallery' => $this->gallery,
            'category' => $this->category,
            'industry' => $this->industry,
            'technologies' => $this->technologies,
            'features' => $this->features,
            'live_url' => $this->live_url,
            'github_url' => $this->github_url,
            'featured' => $this->featured,
            'published' => $this->published,
            'sort_order' => $this->sort_order,
            'views' => $this->views,
            'project_duration' => $this->project_duration,
            'project_budget' => $this->project_budget,
            'client_name' => $this->client_name,
            'results' => $this->results,
            'challenge' => $this->challenge,
            'solution' => $this->solution,
            'impact' => $this->impact,
            'seo_title' => $this->seo_title,
            'seo_description' => $this->seo_description,
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
                'avatar' => $this->author->avatar,
            ],
            'testimonials' => $this->whenLoaded('testimonials', function () {
                return TestimonialResource::collection($this->testimonials);
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}

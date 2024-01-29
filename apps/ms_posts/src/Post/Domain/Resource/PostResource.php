<?php

namespace Modules\Post\Domain\Resource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Undocumented function
     *
     * @return array<string, string|int>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'created_at' => $this->created_at->format('Y-m-d h:m:s'),
            'updated_at' => $this->updated_at->format('Y-m-d h:m:s'),
        ];
    }
}

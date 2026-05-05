<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'blog_post_id'  => $this->blog_post_id,
            'author' => $this->user->full_name ?? $this->user->name,
            'text'   => $this->text,
            'date'   => $this->created_at->format('d.m.Y H:i'),
        ];
    }
}

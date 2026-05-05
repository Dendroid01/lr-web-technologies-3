<?php

namespace App\Services;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Collection;

class CommentService
{
    public function getForPost(int $postId): Collection
    {
        return Comment::where('blog_post_id', $postId)
            ->with('user:id,name,last_name,first_name')
            ->latest()
            ->get();
    }

    public function store(int $postId, int $userId, string $text): Comment
    {
        return Comment::create([
            'blog_post_id' => $postId,
            'user_id'      => $userId,
            'text'         => $text,
        ]);
    }
}

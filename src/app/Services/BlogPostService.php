<?php

namespace App\Services;

use App\Models\BlogPost;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\BlogPostRequest;

class BlogPostService
{
    public function create(array $data, ?UploadedFile $image = null): BlogPost
    {
        if ($image) {
            $data['image'] = $image->store('blog', 'public');
        }

        return BlogPost::create($data);
    }

    public function update(BlogPost $post, array $data, ?UploadedFile $image = null): BlogPost
    {
        if ($image) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $image->store('blog', 'public');
        }

        $post->update($data);
        return $post;
    }

    public function delete(BlogPost $post): void
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();
    }
}

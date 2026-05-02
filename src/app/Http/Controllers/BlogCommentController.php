<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    // Получение комментариев для поста (JSONP response)
    public function index(Request $request, $postId)
    {
        $comments = Comment::where('blog_post_id', $postId)
            ->with('user:id,name,last_name,first_name')
            ->latest()
            ->get()
            ->map(function ($comment) {
                return [
                    'id'     => $comment->id,
                    'author' => $comment->user->full_name ?? $comment->user->name,
                    'text'   => $comment->text,
                    'date'   => $comment->created_at->format('d.m.Y H:i'),
                ];
            });

        $callback = $request->get('callback');
        $json = json_encode($comments);

        if ($callback) {
            return response($callback . '(' . $json . ');')
                ->header('Content-Type', 'application/javascript');
        }

        return response($json)->header('Content-Type', 'application/json');
    }

    // Добавление комментария (JSONP response)
    public function store(Request $request)
    {
        $callback = $request->get('callback');

        if (!Auth::check()) {
            $response = [
                'success' => false,
                'message' => 'Требуется авторизация'
            ];

            $json = json_encode($response);
            if ($callback) {
                return response($callback . '(' . $json . ');')
                    ->header('Content-Type', 'application/javascript');
            }
            return response($json, 401)->header('Content-Type', 'application/json');
        }

        $validated = $request->validate([
            'blog_post_id' => 'required|exists:blog_posts,id',
            'text'         => 'required|string|min:3|max:1000',
        ]);

        $comment = Comment::create([
            'blog_post_id' => $validated['blog_post_id'],
            'user_id'      => Auth::id(),
            'text'         => $validated['text'],
        ]);

        $response = [
            'success' => true,
            'comment' => [
                'id'            => $comment->id,
                'blog_post_id'  => $comment->blog_post_id,
                'author'        => Auth::user()->full_name ?? Auth::user()->name,
                'text'          => $comment->text,
                'date'          => $comment->created_at->format('d.m.Y H:i'),
            ]
        ];

        $json = json_encode($response);

        if ($callback) {
            return response($callback . '(' . $json . ');')
                ->header('Content-Type', 'application/javascript');
        }

        return response($json)->header('Content-Type', 'application/json');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    public function __construct(
        private readonly CommentService $commentService
    ) {}

    public function index(Request $request, int $postId): \Illuminate\Http\Response
    {
        $comments = CommentResource::collection(
            $this->commentService->getForPost($postId)
        );

        $callback = $request->get('callback');
        $json = $comments->toJson();

        if ($callback) {
            return response($callback . '(' . $json . ');')
                ->header('Content-Type', 'application/javascript');
        }

        return response($json)->header('Content-Type', 'application/json');
    }

    public function store(Request $request): \Illuminate\Http\Response
    {
        $callback = $request->get('callback');

        if (!Auth::check()) {
            $response = ['success' => false, 'message' => 'Требуется авторизация'];
            return $this->jsonpResponse($response, 401, $callback);
        }

        $validated = $request->validate([
            'blog_post_id' => 'required|exists:blog_posts,id',
            'text'         => 'required|string|min:3|max:1000',
        ]);

        $comment = $this->commentService->store(
            $validated['blog_post_id'],
            Auth::id(),
            $validated['text']
        );

        $response = [
            'success' => true,
            'comment' => (new CommentResource($comment))->toArray($request)
        ];

        return $this->jsonpResponse($response, 200, $callback);
    }

    private function jsonpResponse(array $data, int $status, ?string $callback): \Illuminate\Http\Response
    {
        $json = json_encode($data);

        if ($callback) {
            return response($callback . '(' . $json . ');', $status)
                ->header('Content-Type', 'application/javascript');
        }

        return response($json, $status)->header('Content-Type', 'application/json');
    }
}

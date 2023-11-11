<?php

namespace App\Http\Controllers;

use App\Http\Requests\OffsetLimitRequest;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index(OffsetLimitRequest $request): JsonResponse
    {
        $limit = $request->input('limit', 10);
        $offset = $request->input('offset', 0);

        $language = $request->header('Accept-Language'); // Get the Accept-Language header

        // Description field to use based on the language
        $descriptionField = 'description_' . $language;

        $posts = Post::offset($offset)
            ->limit($limit)
            ->get(['id', 'title', $descriptionField, 'image_url']);

        return response()->success($posts);
    }

    public function store(PostStoreRequest $request): JsonResponse
    {
        $user = Auth::user();
        $postData = $request->validated();
        $post = $user->posts()->create($postData);

        return response()->success($post);
    }

    public function show(Post $post): JsonResponse
    {
        return response()->success($post);
    }

    public function update(PostUpdateRequest $request, Post $post): JsonResponse
    {

        $user = Auth::user();
        if ($user->id !== $post->user_id) {
            return response()->error(['error' => 'You are not authorized to update this post'], 403);
        }

        $postData = $request->validated();
        $post->update($postData);

        return response()->success($post);
    }

    public function destroy(Post $post): JsonResponse
    {

        $user = Auth::user();

        // Check if the user is an Admin or Moderator
        if ($user->type === 1 || $user->type === 2) {
            $post->delete();
            return response()->success(['message' => 'Post deleted successfully']);
        }

        if ($user->id !== $post->user_id) {
            return response()->error(['error' => 'You are not authorized to delete this post'], 403);
        }

        $post->delete();

        return response()->success(['message' => 'Post deleted successfully']);

    }
}

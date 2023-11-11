<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentReplyRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(CommentStoreRequest $request): JsonResponse
    {
        $commentData = $request->validated();
        $commentData['user_id'] = Auth::id();
        $comment = Comment::create($commentData);

        return response()->success($comment);
    }

    public function reply(CommentReplyRequest $request): JsonResponse
    {
        $commentData = $request->validated();
        $commentData['user_id'] = Auth::id();
        $reply = Comment::create($commentData);

        return response()->success($reply);
    }
}

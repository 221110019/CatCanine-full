<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CommentController extends Controller
{
    use AuthorizesRequests;
    public function index($postId)
    {
        return Comment::where('post_id', $postId)->orderBy('created_at')->get();
    }

    public function store(CommentRequest $request, $postId)
    {
        $this->authorize('create', Comment::class);
        $data = $request->validated();
        $data['post_id'] = $postId;
        $data['user_id'] = $request->user()->id;
        $comment = Comment::create($data);
        return response()->json($comment, 201);
    }

    public function update(CommentRequest $request, $id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('update', $comment);
        $comment->update($request->validated());
        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $this->authorize('delete', $comment);
        $comment->delete();
        return response()->noContent();
    }
}

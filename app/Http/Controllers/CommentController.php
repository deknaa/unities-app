<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Comment added successfully!');
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $reply = new Comment();
        $reply->user_id = Auth::id();
        $reply->post_id = $comment->post_id;
        $reply->parent_id = $comment->id;
        $reply->content = $request->content;
        $reply->save();

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Reply added successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Comment deleted successfully!');
    }
}

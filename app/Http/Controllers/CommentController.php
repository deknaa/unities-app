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
            'content' => 'required|string|max:1500',
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->content = $request->content;
        $comment->save();

        return redirect()->route('posts.show', $post->id)->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function reply(Request $request, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string|max:1500',
        ]);

        $reply = new Comment();
        $reply->user_id = Auth::id();
        $reply->post_id = $comment->post_id;
        $reply->parent_id = $comment->id;
        $reply->content = $request->content;
        $reply->save();

        return redirect()->route('posts.show', $comment->post_id)->with('success', 'Balasan pesan berhasil ditambahkan!');
    }

    public function destroy(Comment $comment)
    {
        // Check if user is authorized to delete the comment
        if (Auth::user()->id !== $comment->user_id && !Auth::user()->role === 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus komentar ini.');
        }

        // Delete the comment
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar telah berhasil dihapus,');
    }
}

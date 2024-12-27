<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function like(Post $post)
    {
        // Periksa apakah pengguna sudah menyukai post
        $alreadyLiked = $post->likes()->where('user_id', Auth::id())->exists();

        if ($alreadyLiked) {
            return redirect()->route('dashboard')->with('error', 'Anda telah menyukai postingan ini');
        }

        // Tambahkan like
        $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Postingan berhasil disukai!');
    }

    public function unlike(Post $post)
    {
        // Periksa apakah pengguna sudah menyukai post
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if (!$like) {
            return redirect()->route('dashboard')->with('error', 'Anda belum menyukai postingan ini');
        }

        // Hapus like
        $like->delete();

        return redirect()->route('dashboard')->with('error', 'Postingan berhasil dihapus dari daftar menyukai');
    }

    public function toggle(Post $post)
    {
        $user = Auth::user();
        $alreadyLiked = $post->likes()->where('user_id', $user->id)->exists();

        if ($alreadyLiked) {
            $post->likes()->where('user_id', $user->id)->delete();
            $status = 'unliked';
        } else {
            $post->likes()->create(['user_id' => $user->id]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'count' => $post->likes()->count(),
        ]);
    }
}

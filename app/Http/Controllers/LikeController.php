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
            return response()->json(['message' => 'Anda telah menyukai postingan ini'], 400);
        }

        // Tambahkan like
        $post->likes()->create([
            'user_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Postingan berhasil disukai']);
    }

    public function unlike(Post $post)
    {
        // Periksa apakah pengguna sudah menyukai post
        $like = $post->likes()->where('user_id', Auth::id())->first();

        if (!$like) {
            return response()->json(['message' => 'Anda belum menyukai postingan ini'], 400);
        }

        // Hapus like
        $like->delete();

        return response()->json(['message' => 'Postingan berhasil dihapus dari daftar menyukai']);
    }
}

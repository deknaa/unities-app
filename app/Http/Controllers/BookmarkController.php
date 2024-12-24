<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function store(Post $post)
    {
        // Periksa apakah post sudah di-bookmark
        $alreadyBookmarked = $post->bookmarks()->where('user_id', Auth::id())->exists();

        if ($alreadyBookmarked) {
            return response()->json(['message' => 'Anda telah menyimpan postingan ini'], 400);
        }

        // Tambahkan bookmark
        $post->bookmarks()->create([
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Postingan berhasil disimpan!');
    }

    public function destroy(Post $post)
    {
        // Periksa apakah post di-bookmark oleh user
        $bookmark = $post->bookmarks()->where('user_id', Auth::id())->first();

        if (!$bookmark) {
            return response()->json(['message' => 'Anda belum menyimpan postingan ini'], 400);
        }

        // Hapus bookmark
        $bookmark->delete();

        return redirect()->route('bookmarks.index')->with('success', 'Simpanan postingan berhasil dihapus!');
    }
}

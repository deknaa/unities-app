<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{

    // BookmarksController.php
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', Auth::id())
            ->with('post.user') // Memuat postingan dan pembuatnya
            ->get();

        return view('bookmarks.index', compact('bookmarks'));
    }

    public function store(Post $post)
    {
        // Periksa apakah post sudah di-bookmark
        $alreadyBookmarked = $post->bookmarks()->where('user_id', Auth::id())->exists();

        if ($alreadyBookmarked) {
            return redirect()->back()->with('error', 'Anda tidak dapat menyimpan postingan yang sudah disimpan!');
        }

        // Tambahkan bookmark
        $post->bookmarks()->create([
            'user_id' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Postingan berhasil disimpan!');
    }

    public function destroy(Post $post)
    {
        // Periksa apakah post di-bookmark oleh user
        $bookmark = $post->bookmarks()->where('user_id', Auth::id())->first();

        if (!$bookmark) {
            return redirect()->back()->with('error', 'Postingan belum disimpan!');
        }

        // Hapus bookmark
        $bookmark->delete();

        return redirect()->back()->with('success', 'Simpanan postingan berhasil dihapus!');
    }
}

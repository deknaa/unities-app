<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Embed\Embed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,wmv,webm|max:3072',
        ]);
    
        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;
    
        if ($request->hasFile('media')) {
            $filePath = $request->file('media')->store('media', 'public');
            $post->media_type = $request->file('media')->getMimeType();
            $post->media_path = $filePath;
        }
    
        preg_match_all('/\bhttps?:\/\/\S+/i', $request->content, $matches);
        $urls = $matches[0] ?? [];
    
        $preview_data = null;
        
        if (!empty($urls)) {
            $embed = new Embed();
            
            try {
                $info = $embed->get($urls[0]);
                
                $preview_data = [
                    'url' => $urls[0],
                    'title' => $info->title ?? null,
                    'description' => $info->description ?? null,
                    'image' => $info->image ? (string)$info->image : null,
                    'favicon' => $info->favicon ? (string)$info->favicon : null,
                    'provider_name' => $info->providerName ?? null
                ];
            } catch (\Exception $e) {
                \Log::error('URL preview error: ' . $e->getMessage());
            }
        }
    
        $post->preview_data = $preview_data;
        $post->save();
    
        return redirect()->route('dashboard')->with('success', 'Postingan anda telah berhasil dibuat');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update', $post); // Optional: Policy untuk akses edit
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $request->validate([
            'content' => 'required|string|max:500',
            'media' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4|max:2048',
        ]);

        $post->content = $request->content;

        if ($request->hasFile('media')) {
            // Hapus file lama jika ada
            if ($post->media_path) {
                \Storage::disk('public')->delete($post->media_path);
            }

            $filePath = $request->file('media')->store('media', 'public');
            $post->media_type = $request->file('media')->getMimeType();
            $post->media_path = $filePath;
        }

        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->media_path) {
            \Storage::disk('public')->delete($post->media_path);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', 'Post deleted successfully!');
    }
}

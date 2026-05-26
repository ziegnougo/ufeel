<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts    = Post::published()->latest('published_at')->paginate(9);
        $featured = Post::published()->featured()->latest('published_at')->first();

        return view('frontend.posts.index', compact('posts', 'featured'));
    }

    public function show(string $slug)
    {
        $post    = Post::where('slug', $slug)->published()->firstOrFail();
        $related = Post::published()
            ->where('category', $post->category)
            ->where('id', '!=', $post->id)
            ->limit(3)
            ->get();

        return view('frontend.posts.show', compact('post', 'related'));
    }
}

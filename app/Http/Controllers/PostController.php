<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;

class PostController extends Controller
{
    public function index()
    {
        return Inertia::render('Life/Index', [
            'posts' => Post::published()->ordered()->get()->map->card(),
        ]);
    }

    public function show(string $locale, Post $post)
    {
        abort_unless($post->is_published, 404);

        return Inertia::render('Life/Show', [
            'post' => $post->card(),
            'more' => Post::published()->ordered()->whereKeyNot($post->id)->limit(3)->get()->map->card(),
        ]);
    }
}

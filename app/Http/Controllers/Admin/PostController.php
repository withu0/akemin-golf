<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::orderByDesc('published_at')->orderBy('sort')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.posts.form', ['post' => new Post(['published_at' => now()])]);
    }

    public function store(Request $request)
    {
        $post = new Post();
        $this->fill($post, $request);
        $post->save();

        return redirect()->route('admin.posts.index')->with('status', '記事を追加しました。');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.form', ['post' => $post]);
    }

    public function update(Request $request, Post $post)
    {
        $this->fill($post, $request);
        $post->save();

        return redirect()->route('admin.posts.index')->with('status', '記事を更新しました。');
    }

    public function destroy(Post $post)
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }
        $post->delete();

        return back()->with('status', '記事を削除しました。');
    }

    private function fill(Post $post, Request $request): void
    {
        $data = $request->validate([
            'slug'         => ['nullable', 'string', 'max:160'],
            'category'     => ['nullable', 'string', 'max:60'],
            'title'        => ['required', 'array'],
            'title.ja'     => ['required', 'string', 'max:200'],
            'excerpt'      => ['nullable', 'array'],
            'body'         => ['nullable', 'array'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
            'sort'         => ['nullable', 'integer'],
            'cover_image'  => ['nullable', 'image', 'max:25600'],
        ]);

        $post->slug = $data['slug'] ?: Str::slug($data['title']['ja']).'-'.Str::random(5);
        // guarantee uniqueness if slug collides
        while (Post::where('slug', $post->slug)->whereKeyNot($post->id ?? 0)->exists()) {
            $post->slug .= '-'.Str::random(3);
        }

        $post->category     = $data['category'] ?? 'life';
        $post->title        = $data['title'];
        $post->excerpt      = $data['excerpt'] ?? null;
        $post->body         = $data['body'] ?? null;
        $post->is_published = $request->boolean('is_published');
        $post->published_at = $data['published_at'] ?? now();
        $post->sort         = (int) ($data['sort'] ?? 0);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) {
                Storage::disk('public')->delete($post->cover_image);
            }
            $post->cover_image = $request->file('cover_image')->store('uploads/posts', 'public');
        }
    }
}

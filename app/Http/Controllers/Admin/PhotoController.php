<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        return view('admin.photos.index', [
            'photos' => Photo::orderBy('sort')->orderByDesc('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'photos'   => ['required', 'array'],
            'photos.*' => ['image', 'max:25600'],
            'album'    => ['nullable', 'string', 'max:80'],
        ]);

        foreach ($request->file('photos') as $file) {
            Photo::create([
                'path'  => $file->store('uploads/gallery', 'public'),
                'album' => $request->input('album'),
            ]);
        }

        return back()->with('status', '写真をアップロードしました。');
    }

    public function destroy(Photo $photo)
    {
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return back()->with('status', '写真を削除しました。');
    }
}

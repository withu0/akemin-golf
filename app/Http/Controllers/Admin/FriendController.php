<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Friend;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FriendController extends Controller
{
    public function index()
    {
        return view('admin.friends.index', [
            'friends' => Friend::orderBy('sort')->orderBy('id')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.friends.form', ['friend' => new Friend()]);
    }

    public function store(Request $request)
    {
        $friend = new Friend();
        $this->fill($friend, $request);
        $friend->save();

        return redirect()->route('admin.friends.index')->with('status', 'ゴルフ友を追加しました。');
    }

    public function edit(Friend $friend)
    {
        return view('admin.friends.form', ['friend' => $friend]);
    }

    public function update(Request $request, Friend $friend)
    {
        $this->fill($friend, $request);
        $friend->save();

        return redirect()->route('admin.friends.index')->with('status', 'ゴルフ友を更新しました。');
    }

    public function destroy(Friend $friend)
    {
        if ($friend->photo) {
            Storage::disk('public')->delete($friend->photo);
        }
        if ($friend->video) {
            Storage::disk('public')->delete($friend->video);
        }
        $friend->delete();

        return back()->with('status', '削除しました。');
    }

    private function fill(Friend $friend, Request $request): void
    {
        $data = $request->validate([
            'name'         => ['required', 'string', 'max:120'],
            'country'      => ['nullable', 'string', 'max:120'],
            'flag'         => ['nullable', 'string', 'max:16'],
            'instagram'    => ['nullable', 'string', 'max:200'],
            'message'      => ['nullable', 'array'],
            'is_published' => ['nullable', 'boolean'],
            'sort'         => ['nullable', 'integer'],
            'photo'        => ['nullable', 'image', 'max:25600'],
            'video'        => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:102400'],
        ]);

        $friend->name      = $data['name'];
        $friend->country   = $data['country'] ?? null;
        $friend->flag      = $data['flag'] ?? null;
        $friend->instagram = $data['instagram'] ?? null;
        $friend->message   = $data['message'] ?? null;
        $friend->is_published = $request->boolean('is_published');
        $friend->sort      = (int) ($data['sort'] ?? 0);

        if ($request->hasFile('photo')) {
            if ($friend->photo) {
                Storage::disk('public')->delete($friend->photo);
            }
            $friend->photo = $request->file('photo')->store('uploads/friends', 'public');
        }

        if ($request->hasFile('video')) {
            if ($friend->video) {
                Storage::disk('public')->delete($friend->video);
            }
            $friend->video = $request->file('video')->store('uploads/friends', 'public');
        }
    }
}

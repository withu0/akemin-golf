<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        return view('admin.activities.index', [
            'activities' => Activity::orderByDesc('happened_on')->orderBy('sort')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.activities.form', ['activity' => new Activity()]);
    }

    public function store(Request $request)
    {
        $activity = new Activity();
        $this->fill($activity, $request);
        $activity->save();

        return redirect()->route('admin.activities.index')->with('status', '活動を追加しました。');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.form', ['activity' => $activity]);
    }

    public function update(Request $request, Activity $activity)
    {
        $this->fill($activity, $request);
        $activity->save();

        return redirect()->route('admin.activities.index')->with('status', '活動を更新しました。');
    }

    public function destroy(Activity $activity)
    {
        if ($activity->cover_image) {
            Storage::disk('public')->delete($activity->cover_image);
        }
        if ($activity->video) {
            Storage::disk('public')->delete($activity->video);
        }
        $activity->delete();

        return back()->with('status', '活動を削除しました。');
    }

    private function fill(Activity $activity, Request $request): void
    {
        $data = $request->validate([
            'title'        => ['required', 'array'],
            'title.ja'     => ['required', 'string', 'max:200'],
            'title.en'     => ['nullable', 'string', 'max:200'],
            'title.zh'     => ['nullable', 'string', 'max:200'],
            'body'         => ['nullable', 'array'],
            'location'     => ['nullable', 'string', 'max:160'],
            'happened_on'  => ['nullable', 'date'],
            'is_published' => ['nullable', 'boolean'],
            'sort'         => ['nullable', 'integer'],
            'cover_image'  => ['nullable', 'image', 'max:25600'],
            'video'        => ['nullable', 'file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:102400'],
        ]);

        $activity->title       = $data['title'];
        $activity->body        = $data['body'] ?? null;
        $activity->location    = $data['location'] ?? null;
        $activity->happened_on = $data['happened_on'] ?? null;
        $activity->is_published = $request->boolean('is_published');
        $activity->sort        = (int) ($data['sort'] ?? 0);

        if ($request->hasFile('cover_image')) {
            if ($activity->cover_image) {
                Storage::disk('public')->delete($activity->cover_image);
            }
            $activity->cover_image = $request->file('cover_image')->store('uploads/activities', 'public');
        }

        if ($request->hasFile('video')) {
            if ($activity->video) {
                Storage::disk('public')->delete($activity->video);
            }
            $activity->video = $request->file('video')->store('uploads/activities', 'public');
        }
    }
}

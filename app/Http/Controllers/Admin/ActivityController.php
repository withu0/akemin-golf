<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ActivityMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        return view('admin.activities.index', [
            'activities' => Activity::with('coverMedia')
                ->orderByDesc('happened_on')
                ->orderBy('sort')
                ->get(),
        ]);
    }

    public function create()
    {
        return view('admin.activities.form', ['activity' => new Activity()]);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $activity = new Activity();
            $this->fill($activity, $request);
            $activity->save();
            $this->syncMedia($activity, $request);
        });

        return redirect()->route('admin.activities.index')->with('status', '活動を追加しました。');
    }

    public function edit(Activity $activity)
    {
        $activity->load(['media', 'coverMedia']);

        return view('admin.activities.form', ['activity' => $activity]);
    }

    public function update(Request $request, Activity $activity)
    {
        DB::transaction(function () use ($request, $activity) {
            $this->fill($activity, $request);
            $activity->save();
            $this->syncMedia($activity, $request);
        });

        return redirect()->route('admin.activities.index')->with('status', '活動を更新しました。');
    }

    public function destroy(Activity $activity)
    {
        $activity->delete();

        return back()->with('status', '活動を削除しました。');
    }

    private function fill(Activity $activity, Request $request): void
    {
        $data = $request->validate([
            'title'          => ['required', 'array'],
            'title.ja'       => ['required', 'string', 'max:200'],
            'title.en'       => ['nullable', 'string', 'max:200'],
            'title.zh'       => ['nullable', 'string', 'max:200'],
            'body'           => ['nullable', 'array'],
            'location'       => ['nullable', 'string', 'max:160'],
            'happened_on'    => ['nullable', 'date'],
            'is_published'   => ['nullable', 'boolean'],
            'sort'           => ['nullable', 'integer'],
            'media_images'   => ['nullable', 'array'],
            'media_images.*' => ['image', 'max:25600'],
            'media_videos'   => ['nullable', 'array'],
            'media_videos.*' => ['file', 'mimetypes:video/mp4,video/webm,video/quicktime', 'max:102400'],
            'cover_media_id' => ['nullable', 'integer'],
            'delete_media'   => ['nullable', 'array'],
            'delete_media.*' => ['integer'],
        ]);

        $activity->title        = $data['title'];
        $activity->body         = $data['body'] ?? null;
        $activity->location     = $data['location'] ?? null;
        $activity->happened_on  = $data['happened_on'] ?? null;
        $activity->is_published = $request->boolean('is_published');
        $activity->sort         = (int) ($data['sort'] ?? 0);
    }

    private function syncMedia(Activity $activity, Request $request): void
    {
        $deleteIds = collect($request->input('delete_media', []))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->all();

        if ($deleteIds !== []) {
            $toDelete = $activity->media()->whereIn('id', $deleteIds)->get();

            if (in_array((int) $activity->cover_media_id, $deleteIds, true)) {
                $activity->cover_media_id = null;
                $activity->saveQuietly();
            }

            foreach ($toDelete as $media) {
                Storage::disk('public')->delete($media->path);
                $media->delete();
            }
        }

        $nextSort = (int) $activity->media()->max('sort') + 1;

        foreach (array_filter($request->file('media_images') ?? []) as $file) {
            ActivityMedia::create([
                'activity_id' => $activity->id,
                'path'        => $file->store('uploads/activities', 'public'),
                'type'        => 'image',
                'sort'        => $nextSort++,
            ]);
        }

        foreach (array_filter($request->file('media_videos') ?? []) as $file) {
            ActivityMedia::create([
                'activity_id' => $activity->id,
                'path'        => $file->store('uploads/activities', 'public'),
                'type'        => 'video',
                'sort'        => $nextSort++,
            ]);
        }

        $activity->load('media');

        $coverId = $request->input('cover_media_id');
        if ($coverId && $activity->media->contains('id', (int) $coverId)) {
            $activity->cover_media_id = (int) $coverId;
        } elseif (! $activity->cover_media_id || ! $activity->media->contains('id', (int) $activity->cover_media_id)) {
            $activity->cover_media_id = $activity->media->first()?->id;
        }

        $activity->saveQuietly();
    }
}

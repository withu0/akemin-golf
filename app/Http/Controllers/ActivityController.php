<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Inertia\Inertia;

class ActivityController extends Controller
{
    public function index()
    {
        return Inertia::render('Activities/Index', [
            'activities' => Activity::published()
                ->ordered()
                ->with('coverMedia')
                ->get()
                ->map->card(),
        ]);
    }

    public function show(string $locale, Activity $activity)
    {
        abort_unless($activity->is_published, 404);

        $activity->load(['coverMedia', 'media']);

        return Inertia::render('Activities/Show', [
            'activity' => $activity->card(withGallery: true),
            'more'     => Activity::published()
                ->ordered()
                ->with('coverMedia')
                ->whereKeyNot($activity->id)
                ->limit(3)
                ->get()
                ->map->card(),
        ]);
    }
}

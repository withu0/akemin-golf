<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Application;
use App\Models\Friend;
use App\Models\Photo;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'counts' => [
                'activities'   => Activity::count(),
                'friends'      => Friend::count(),
                'posts'        => Post::count(),
                'photos'       => Photo::count(),
                'applications' => Application::count(),
                'new_apps'     => Application::where('handled', false)->count(),
            ],
            'recentApps' => Application::latest()->limit(5)->get(),
        ]);
    }
}

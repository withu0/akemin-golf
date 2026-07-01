<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Friend;
use App\Models\Post;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [
            'hero'       => site_section('hero')->content(),
            'about'      => site_section('about')->content(),
            'activities' => Activity::published()->ordered()->limit(3)->get()->map->card(),
            'friends'    => Friend::published()->ordered()->limit(4)->get()->map->card(),
            'posts'      => Post::published()->ordered()->limit(2)->get()->map->card(),
        ]);
    }

    public function about()
    {
        return Inertia::render('About', [
            'about'    => site_section('about')->content(),
            'portrait' => media_url('media/portrait.jpg'),
            'film'     => media_url('media/golf.mp4'),
            'poster'   => media_url('media/portrait.jpg'),
        ]);
    }

    public function beauty()
    {
        return Inertia::render('Beauty', [
            'beauty' => site_section('beauty')->content(),
        ]);
    }

    public function future()
    {
        return Inertia::render('Future', [
            'future' => site_section('future')->content(),
        ]);
    }

    public function global()
    {
        return Inertia::render('Global', [
            'global'  => site_section('global')->content(),
            'friends' => Friend::published()->ordered()->get()->map->card(),
        ]);
    }
}

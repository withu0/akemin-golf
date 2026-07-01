<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use Inertia\Inertia;

class FriendController extends Controller
{
    public function index()
    {
        return Inertia::render('Friends/Index', [
            'friends' => Friend::published()->ordered()->get()->map->card(),
        ]);
    }
}

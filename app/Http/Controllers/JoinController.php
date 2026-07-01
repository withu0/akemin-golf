<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JoinController extends Controller
{
    public function create()
    {
        return Inertia::render('Join', [
            'image' => media_url('media/la-round.jpg'),
        ]);
    }

    public function store(string $locale, Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:120'],
            'email'    => ['nullable', 'email', 'max:160'],
            'country'  => ['nullable', 'string', 'max:120'],
            'interest' => ['nullable', 'string', 'max:60'],
            'message'  => ['nullable', 'string', 'max:3000'],
        ]);

        $data['locale'] = app()->getLocale();

        Application::create($data);

        return redirect()->route('join')->with('joined', true);
    }
}

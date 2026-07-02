<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Props shared with every Inertia page.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'locale'  => fn () => app()->getLocale(),
            'locales' => config('site.locales'),
            'site'    => [
                'brand_ja'   => config('site.brand_ja'),
                'brand_en'   => config('site.brand_en'),
                'owner_ja'   => config('site.owner_ja'),
                'owner_en'   => config('site.owner_en'),
                'tagline_en' => config('site.tagline_en'),
                'instagram'  => config('site.instagram'),
                'harisienne' => config('site.harisienne'),
            ],
            // Evaluated after SetLocale middleware so the active locale is correct.
            'lang' => fn () => trans('site'),
            'flash' => [
                'joined' => fn () => $request->session()->get('joined'),
            ],
        ]);
    }
}

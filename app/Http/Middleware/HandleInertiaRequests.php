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
        $locale = app()->getLocale();

        return array_merge(parent::share($request), [
            'locale'  => $locale,
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
            // UI strings for the active locale (nav, cta, meta, footer, join, home, purpose, beauty)
            'lang' => trans('site'),
            // Current path without locale prefix, so the client can build language-switch URLs
            'flash' => [
                'joined' => fn () => $request->session()->get('joined'),
            ],
        ]);
    }
}

<?php

use App\Models\Section;
use Illuminate\Support\Facades\Schema;

if (! function_exists('site_section')) {
    /**
     * Fetch an editable content section by key (request-cached).
     * Returns a blank Section if not seeded yet, so views never break.
     */
    function site_section(string $key): Section
    {
        static $cache = null;

        if ($cache === null) {
            $cache = Schema::hasTable('sections')
                ? Section::all()->keyBy('key')
                : collect();
        }

        return $cache->get($key) ?? new Section(['key' => $key]);
    }
}

if (! function_exists('media_url')) {
    /**
     * Resolve an image/media path to a public URL.
     * Accepts absolute URLs, public-disk relative paths, or null.
     */
    function media_url(?string $path, ?string $fallback = null): ?string
    {
        $path = $path ?: $fallback;

        if (! $path) {
            return null;
        }
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Relative path so images work on whichever port `artisan serve` uses.
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'storage/')) {
            return '/'.$path;
        }

        return '/storage/'.$path;
    }
}

if (! function_exists('locales')) {
    /** @return array<string, array<string, string>> */
    function locales(): array
    {
        return config('site.locales');
    }
}

if (! function_exists('switch_locale_url')) {
    /**
     * Current URL rewritten to a different locale (first path segment).
     */
    function switch_locale_url(string $locale): string
    {
        $path = trim(request()->path(), '/');           // e.g. "ja/about"
        $segments = $path === '' ? [] : explode('/', $path);

        if (! empty($segments) && array_key_exists($segments[0], config('site.locales'))) {
            $segments[0] = $locale;
        } else {
            array_unshift($segments, $locale);
        }

        $query = request()->getQueryString();

        return url(implode('/', $segments)).($query ? '?'.$query : '');
    }
}

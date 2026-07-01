<?php

namespace App\Concerns;

/**
 * Lightweight, dependency-free translatable fields.
 *
 * Translatable columns are stored as JSON keyed by locale, e.g.
 *   {"ja": "...", "en": "...", "zh": "..."}
 *
 * A model opts in by listing the columns in $translatable and casting
 * them to 'array'. Use t('field') to read the value for the active
 * locale, with graceful fallback to the app fallback locale, then to
 * the first non-empty value.
 */
trait HasTranslations
{
    /**
     * Read a translatable field for the given (or active) locale.
     */
    public function t(string $field, ?string $locale = null): string
    {
        $locale ??= app()->getLocale();
        $value = $this->getAttribute($field);

        if (is_array($value)) {
            $fallback = config('app.fallback_locale', 'ja');

            if (! empty($value[$locale])) {
                return (string) $value[$locale];
            }
            if (! empty($value[$fallback])) {
                return (string) $value[$fallback];
            }
            foreach ($value as $candidate) {
                if (! empty($candidate)) {
                    return (string) $candidate;
                }
            }
            return '';
        }

        return (string) ($value ?? '');
    }

    /**
     * Convenience: the list of translatable attribute names.
     *
     * @return array<int, string>
     */
    public function translatableFields(): array
    {
        return $this->translatable ?? [];
    }
}

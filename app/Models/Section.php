<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title', 'lead', 'body', 'extra'];

    protected function casts(): array
    {
        return [
            'title' => 'array',
            'lead'  => 'array',
            'body'  => 'array',
            'extra' => 'array',
        ];
    }

    public static function get(string $key): self
    {
        return static::firstOrNew(['key' => $key]);
    }

    /** Resolved content for the active locale (for Inertia props). */
    public function content(): array
    {
        return [
            'eyebrow' => $this->eyebrow,
            'title'   => $this->t('title'),
            'lead'    => $this->t('lead'),
            'body'    => $this->t('body'),
            'image'   => media_url($this->image),
        ];
    }
}

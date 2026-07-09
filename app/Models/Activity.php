<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title', 'body'];

    protected function casts(): array
    {
        return [
            'title'        => 'array',
            'body'         => 'array',
            'happened_on'  => 'date',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('happened_on')->orderBy('sort');
    }

    public function card(): array
    {
        return [
            'id'       => $this->id,
            'title'    => $this->t('title'),
            'body'     => $this->t('body'),
            'location' => $this->location,
            'date'     => $this->happened_on?->isoFormat('YYYY.MM.DD'),
            'cover'    => media_url($this->cover_image),
            'video'    => media_url($this->video),
            'url'      => route('activities.show', $this),
        ];
    }
}

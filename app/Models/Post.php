<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = ['title', 'excerpt', 'body'];

    protected function casts(): array
    {
        return [
            'title'        => 'array',
            'excerpt'      => 'array',
            'body'         => 'array',
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderBy('sort');
    }

    public function card(): array
    {
        return [
            'id'       => $this->id,
            'slug'     => $this->slug,
            'title'    => $this->t('title'),
            'excerpt'  => $this->t('excerpt'),
            'body'     => $this->t('body'),
            'category' => $this->category,
            'date'     => $this->published_at?->isoFormat('YYYY.MM.DD'),
            'cover'    => media_url($this->cover_image),
            'url'      => route('life.show', $this),
        ];
    }
}

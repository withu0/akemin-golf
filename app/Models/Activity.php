<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function media(): HasMany
    {
        return $this->hasMany(ActivityMedia::class)->ordered();
    }

    public function coverMedia(): BelongsTo
    {
        return $this->belongsTo(ActivityMedia::class, 'cover_media_id');
    }

    protected static function booted(): void
    {
        static::deleting(function (Activity $activity) {
            // Break circular FK (cover_media_id → activity_media) before cascade.
            $activity->cover_media_id = null;
            $activity->saveQuietly();

            foreach ($activity->media()->get() as $media) {
                if ($media->path) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($media->path);
                }
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('happened_on')->orderBy('sort');
    }

    public function card(bool $withGallery = false): array
    {
        $cover = $this->relationLoaded('coverMedia')
            ? $this->coverMedia
            : $this->coverMedia()->first();

        $payload = [
            'id'       => $this->id,
            'title'    => $this->t('title'),
            'body'     => $this->t('body'),
            'location' => $this->location,
            'date'     => $this->happened_on?->isoFormat('YYYY.MM.DD'),
            'cover'    => ($cover && $cover->isImage()) ? $cover->url() : null,
            'video'    => ($cover && $cover->isVideo()) ? $cover->url() : null,
            'url'      => route('activities.show', $this),
        ];

        if ($withGallery) {
            $media = $this->relationLoaded('media')
                ? $this->media
                : $this->media()->get();

            $payload['gallery'] = $media->map->toGalleryItem()->values()->all();
        }

        return $payload;
    }
}

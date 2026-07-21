<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityMedia extends Model
{
    protected $table = 'activity_media';

    protected $guarded = [];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    public function url(): ?string
    {
        return media_url($this->path);
    }

    public function toGalleryItem(): array
    {
        return [
            'id'   => $this->id,
            'url'  => $this->url(),
            'type' => $this->type,
        ];
    }
}

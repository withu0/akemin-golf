<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasTranslations;

    protected $guarded = [];

    public array $translatable = ['message'];

    protected function casts(): array
    {
        return [
            'message'      => 'array',
            'is_published' => 'boolean',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort')->orderBy('id');
    }

    public function card(): array
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'country'   => $this->country,
            'flag'      => $this->flag,
            'instagram' => $this->instagram,
            'photo'     => media_url($this->photo),
            'message'   => $this->t('message'),
        ];
    }
}

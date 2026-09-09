<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentItem extends Model
{
    use HasFactory;

    public const RESULT_TYPES = ['deliverable', 'publication', 'other_result'];

    public const MEDIA_TYPES = ['news', 'event', 'newsletter', 'press'];

    public const TYPES = [...self::RESULT_TYPES, ...self::MEDIA_TYPES];

    protected $fillable = [
        'type', 'title', 'slug', 'reference_code', 'excerpt', 'body', 'partner',
        'published_at', 'event_date', 'status', 'category', 'file_path',
        'external_url', 'image_path', 'is_public', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'date',
            'event_date' => 'datetime',
            'is_public' => 'boolean',
        ];
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_public', true)
            ->where(fn (Builder $q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'deliverable' => 'Deliverable', 'publication' => 'Publication',
            'other_result' => 'Project output', 'news' => 'News', 'event' => 'Event',
            'newsletter' => 'Newsletter', 'press' => 'Press / Media', default => ucfirst($this->type),
        };
    }
}

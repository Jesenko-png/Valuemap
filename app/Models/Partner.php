<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $fillable = [
        'name',
        'initials',
        'country',
        'country_code',
        'location',
        'latitude',
        'longitude',
        'map_offset_x',
        'map_offset_y',
        'role',
        'description',
        'website_url',
        'logo_path',
        'contacts',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'float',
            'longitude' => 'float',
            'map_offset_x' => 'float',
            'map_offset_y' => 'float',
            'contacts' => 'array',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function getDisplayLogoUrlAttribute(): ?string
    {
        $path = $this->logo_path;

        if (! $path) {
            $partner = collect(config('valuemap.partners'))->firstWhere('name', $this->name);
            $path = $partner['logo_path'] ?? null;
        }

        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'images/partners/')
            ? asset($path)
            : asset('storage/'.$path);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order')->orderBy('name');
    }
}

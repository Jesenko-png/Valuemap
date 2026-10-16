<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class NewsletterSubscriber extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['email', 'consent_at', 'confirmed_at', 'unsubscribed_at'];

    protected function casts(): array
    {
        return ['consent_at' => 'datetime', 'confirmed_at' => 'datetime', 'unsubscribed_at' => 'datetime'];
    }

    public function routeNotificationForMail(): string
    {
        return $this->email;
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotNull('confirmed_at')->whereNull('unsubscribed_at');
    }

    public function getStatusLabelAttribute(): string
    {
        if ($this->unsubscribed_at) {
            return 'Unsubscribed';
        }

        return $this->confirmed_at ? 'Confirmed' : 'Pending confirmation';
    }
}

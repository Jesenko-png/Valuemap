<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public const ROLE_MAIN_ADMIN = 'main_admin';

    public const ROLE_ADMIN = 'admin';

    public const ROLE_READER = 'reader';

    public const ROLES = [self::ROLE_MAIN_ADMIN, self::ROLE_ADMIN, self::ROLE_READER];

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'role',
        'requested_role',
        'is_approved',
        'approved_at',
        'approved_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
            'is_approved' => 'boolean',
            'approved_at' => 'datetime',
        ];
    }

    public function isMainAdmin(): bool
    {
        return $this->role === self::ROLE_MAIN_ADMIN;
    }

    public function canManageContent(): bool
    {
        return $this->is_approved && in_array($this->role, [self::ROLE_MAIN_ADMIN, self::ROLE_ADMIN], true);
    }

    public function canSignIn(): bool
    {
        return $this->is_approved;
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_MAIN_ADMIN => 'Main administrator',
            self::ROLE_ADMIN => 'Administrator',
            default => 'Reader',
        };
    }
}

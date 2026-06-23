<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    // === ROLE CHECK METHODS ===
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    // === FORMAT TANGGAL (CEK NULL) ===
    public function getCreatedAtFormatted(): string
    {
        return $this->created_at ? $this->created_at->format('d-m-Y H:i') : '-';
    }

    public function getUpdatedAtFormatted(): string
    {
        return $this->updated_at ? $this->updated_at->format('d-m-Y H:i') : '-';
    }

    public function getCreatedAtFull(): string
    {
        return $this->created_at ? $this->created_at->format('d-m-Y H:i:s') : '-';
    }

    public function getUpdatedAtFull(): string
    {
        return $this->updated_at ? $this->updated_at->format('d-m-Y H:i:s') : '-';
    }

    // === ROLE BADGE ===
    public function getRoleBadge(): string
    {
        return match ($this->role) {
            'admin' => '<span class="badge bg-danger">Admin</span>',
            'user' => '<span class="badge bg-info">User</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    // === SCOPES ===
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }
}

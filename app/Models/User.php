<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ✅ TAMBAHKAN METHOD-METHOD INI
    public function isAdmin()
    {
        return $this->level === 'admin' || $this->level === 'owner';
    }

    public function isOwner()
    {
        return $this->level === 'owner';
    }

    public function isKurir()
    {
        return $this->level === 'kurir';
    }
}

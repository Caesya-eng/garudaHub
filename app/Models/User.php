<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    // Satu user (client) bisa membuat banyak proyek
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // Satu user (freelancer) bisa mengajukan banyak penawaran (bid)
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
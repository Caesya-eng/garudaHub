<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'budget',
        'deadline',
        'status',
    ];

    // Satu proyek dimiliki oleh satu user (client)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Satu proyek bisa menerima banyak penawaran (bids)
    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }
}
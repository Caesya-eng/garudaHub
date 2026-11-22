<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bid extends Model
{
    protected $fillable = [
        'project_id',
        'user_id',
        'amount',
        'proposal',
        'status',
    ];

    // Penawaran ini ditujukan untuk satu proyek tertentu
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Penawaran ini diajukan oleh satu user (freelancer)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Learner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mode_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function mode(): BelongsTo
    {
        return $this->belongsTo(Mode::class);
    }
}

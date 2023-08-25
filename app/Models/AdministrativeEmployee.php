<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdministrativeEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_super_admin',
    ];

    protected $casts = [
        'is_super_admin' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

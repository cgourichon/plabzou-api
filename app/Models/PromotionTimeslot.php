<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PromotionTimeslot extends Model
{
    use SoftDeletes;

    protected $table = 'learner_promotion';

    protected $casts = [
        'timeslot_id' => 'int',
        'promotion_id' => 'int'
    ];

    protected $fillable = [
        'timeslot_id',
        'promotion_id'
    ];

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }
}

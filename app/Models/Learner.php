<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Learner
 *
 * @property int $user_id
 * @property int $mode_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Mode $mode
 * @property User $user
 * @property Collection|Promotion[] $promotions
 * @property Collection|Timeslot[] $timeslots
 *
 * @package App\Models
 */
class Learner extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'learners';
    protected $primaryKey = 'user_id';
    protected $casts = [
        'user_id' => 'int',
        'mode_id' => 'int'
    ];

    protected $fillable = [
        'mode_id'
    ];

    public function mode(): BelongsTo
    {
        return $this->belongsTo(Mode::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function promotions(): BelongsToMany
    {
        return $this->belongsToMany(Promotion::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function timeslots(): BelongsToMany
    {
        return $this->belongsToMany(Timeslot::class)
            ->withPivot('id')
            ->withTimestamps();
    }
}

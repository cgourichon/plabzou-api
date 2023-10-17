<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Timeslot
 *
 * @property int $id
 * @property int $training_id
 * @property int $room_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property bool $is_validated
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Room $room
 * @property Training $training
 * @property Collection|Learner[] $learners
 * @property Collection|Request[] $requests
 * @property Collection|Teacher[] $teachers
 *
 * @package App\Models
 */
class Timeslot extends Model
{
    use SoftDeletes;

    protected $table = 'timeslots';

    protected $casts = [
        'training_id' => 'int',
        'room_id' => 'int',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_validated' => 'bool'
    ];

    protected $fillable = [
        'training_id',
        'room_id',
        'start_date',
        'end_date',
        'is_validated'
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function training(): BelongsTo
    {
        return $this->belongsTo(Training::class);
    }

    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(Learner::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(Teacher::class)
            ->withPivot('id')
            ->withTimestamps();
    }
}

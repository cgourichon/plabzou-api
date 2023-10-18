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
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Teacher
 *
 * @property int $user_id
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Request[] $requests
 * @property Collection|Timeslot[] $timeslots
 * @property Collection|Training[] $trainings
 *
 * @package App\Models
 */
class Teacher extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $table = 'teachers';
    protected $primaryKey = 'user_id';
    protected $casts = [
        'user_id' => 'int'
    ];

    protected $fillable = [
        'status'
    ];

    protected $appends = ['full_name'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    public function timeslots(): BelongsToMany
    {
        return $this->belongsToMany(Timeslot::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(Training::class)
            ->withPivot('id', 'latest_upgrade_date', 'is_active', 'reason')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->full_name;
    }
}

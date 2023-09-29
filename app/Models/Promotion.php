<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Promotion
 *
 * @property int $id
 * @property string $name
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Course[] $courses
 * @property Collection|Learner[] $learners
 *
 * @package App\Models
 */
class Promotion extends Model
{
    protected $table = 'promotions';

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'starts_at',
        'ends_at'
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function learners(): BelongsToMany
    {
        return $this->belongsToMany(Learner::class)
            ->withPivot('id')
            ->withTimestamps();
    }
}
<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Course
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Promotion[] $promotions
 * @property Collection|Training[] $trainings
 *
 * @package App\Models
 */
class Course extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'courses';

    protected $fillable = [
        'name'
    ];

    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function trainings(): BelongsToMany
    {
        return $this->belongsToMany(
            Training::class,
            'training_course',
            'course_id',
            'training_id'
        )
            ->withPivot('id')
            ->withTimestamps();
    }
}

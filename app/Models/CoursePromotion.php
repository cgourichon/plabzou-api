<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class CoursePromotion
 *
 * @property int $id
 * @property int $course_id
 * @property int $promotion_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Course $course
 * @property Promotion $promotion
 *
 * @package App\Models
 */
class CoursePromotion extends Model
{
    protected $table = 'course_promotion';

    protected $casts = [
        'course_id' => 'int',
        'promotion_id' => 'int'
    ];

    protected $fillable = [
        'course_id',
        'promotion_id'
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function promotion(): BelongsTo
    {
        return $this->belongsTo(Promotion::class);
    }
}

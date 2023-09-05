<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Mode
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Learner[] $learners
 *
 * @package App\Models
 */
class Mode extends Model
{
    protected $table = 'modes';

    protected $fillable = [
        'name'
    ];

    public function learners(): HasMany
    {
        return $this->hasMany(Learner::class);
    }
}

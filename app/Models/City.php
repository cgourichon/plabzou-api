<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class City
 *
 * @property int $id
 * @property string $name
 * @property string $postcode
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Place[] $places
 *
 * @package App\Models
 */
class City extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'cities';

    protected $fillable = [
        'name',
        'postcode'
    ];

    public function places(): HasMany
    {
        return $this->hasMany(Place::class);
    }
}

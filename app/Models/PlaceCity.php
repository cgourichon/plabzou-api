<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlaceCity
 *
 * @property int $id
 * @property int $place_id
 * @property int $city_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property City $city
 * @property Place $place
 *
 * @package App\Models
 */
class PlaceCity extends Model
{
    use SoftDeletes;

    protected $table = 'place_city';

    protected $casts = [
        'place_id' => 'int',
        'city_id' => 'int'
    ];

    protected $fillable = [
        'place_id',
        'city_id'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}

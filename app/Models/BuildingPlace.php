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
 * Class BuildingPlace
 *
 * @property int $id
 * @property int $building_id
 * @property int $place_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Building $building
 * @property Place $place
 *
 * @package App\Models
 */
class BuildingPlace extends Model
{
    use SoftDeletes;

    protected $table = 'building_place';

    protected $casts = [
        'building_id' => 'int',
        'place_id' => 'int'
    ];

    protected $fillable = [
        'building_id',
        'place_id'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class);
    }
}

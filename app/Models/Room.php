<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Room
 *
 * @property int $id
 * @property int $building_id
 * @property string $name
 * @property int $seats_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Building $building
 * @property Collection|Timeslot[] $timeslots
 *
 * @package App\Models
 */
class Room extends Model
{
    protected $table = 'rooms';

    protected $casts = [
        'building_id' => 'int',
        'seats_number' => 'int'
    ];

    protected $fillable = [
        'building_id',
        'name',
        'seats_number'
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function timeslots(): HasMany
    {
        return $this->hasMany(Timeslot::class);
    }
}
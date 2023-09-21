<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Building
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Place[] $places
 * @property Collection|Room[] $rooms
 *
 * @package App\Models
 */
class Building extends Model
{
    protected $table = 'buildings';

    protected $fillable = [
        'name',
        'address'
    ];

    public function places(): BelongsToMany
    {
        return $this->belongsToMany(Place::class)
            ->withPivot('id')
            ->withTimestamps();
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}

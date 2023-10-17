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
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Place
 *
 * @property int $id
 * @property string $name
 * @property string $street_address
 * @property int $city_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property City $city
 * @property Collection|Building[] $buildings
 * @property Collection|City[] $cities
 *
 * @package App\Models
 */
class Place extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'places';

    protected $casts = [
        'city_id' => 'int'
    ];

    protected $fillable = [
        'name',
        'street_address',
        'city_id'
    ];

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function buildings(): BelongsToMany
    {
        return $this->belongsToMany(Building::class)
            ->withPivot('id')
            ->withTimestamps();
    }
}

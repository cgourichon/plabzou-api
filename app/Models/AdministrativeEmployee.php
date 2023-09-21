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
 * Class AdministrativeEmployee
 *
 * @property int $user_id
 * @property bool $is_super_admin
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class AdministrativeEmployee extends Model
{
    public $incrementing = false;
    protected $table = 'administrative_employees';
    protected $primaryKey = 'user_id';
    protected $casts = [
        'user_id' => 'int',
        'is_super_admin' => 'bool'
    ];

    protected $fillable = [
        'is_super_admin'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}

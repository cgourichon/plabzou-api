<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $phone_number
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property AdministrativeEmployee $administrative_employee
 * @property Learner $learner
 * @property Collection|Message[] $messages
 * @property Teacher $teacher
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    protected $table = 'users';

    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'phone_number',
        'email',
        'email_verified_at',
        'password',
        'remember_token'
    ];

    public function administrativeEmployee(): HasOne
    {
        return $this->hasOne(AdministrativeEmployee::class);
    }

    public function learner(): HasOne
    {
        return $this->hasOne(Learner::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }
}

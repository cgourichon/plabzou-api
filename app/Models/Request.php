<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'administrative_employee_id',
        'teacher_id',
        'timeslot_id',
        'is_approved',
        'comment',
    ];

    public function administrativeEmployee(): BelongsTo
    {
        return $this->belongsTo(AdministrativeEmployee::class, 'administrative_employee_id', 'user_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'user_id');
    }

    public function timeslot(): BelongsTo
    {
        return $this->belongsTo(Timeslot::class);
    }
}

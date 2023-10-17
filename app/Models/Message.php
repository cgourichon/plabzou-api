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
 * Class Message
 *
 * @property int $id
 * @property int $sender_id
 * @property int $recipient_id
 * @property string $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property User $user
 *
 * @package App\Models
 */
class Message extends Model
{
    use SoftDeletes;

    protected $table = 'messages';

    protected $casts = [
        'sender_id' => 'int',
        'recipient_id' => 'int'
    ];

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'message'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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

    protected $fillable = [
        'sender_id',
        'conversation_id',
        'message'
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id', // الشركة
        'message',
        'response',
        'direction', // incoming, outgoing
        'message_type', // text, image, document, etc.
        'is_read',
        'is_ai_response', // هل الرد من AI أم من الإنسان
        'ai_confidence', // مستوى ثقة AI في الرد
        'metadata', // JSON field for additional data
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_ai_response' => 'boolean',
        'ai_confidence' => 'float',
        'metadata' => 'array',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeIncoming($query)
    {
        return $query->where('direction', 'incoming');
    }

    public function scopeOutgoing($query)
    {
        return $query->where('direction', 'outgoing');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeAiResponses($query)
    {
        return $query->where('is_ai_response', true);
    }
} 
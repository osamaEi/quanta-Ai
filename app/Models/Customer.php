<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // الشركة التي يتبع لها العميل
        'name',
        'phone_number',
        'whatsapp_number',
        'email',
        'company_name',
        'status', // active, inactive, blocked
        'last_contact_at',
        'notes',
        'preferences', // JSON field for customer preferences
    ];

    protected $casts = [
        'last_contact_at' => 'datetime',
        'preferences' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function getLatestConversation()
    {
        return $this->conversations()->latest()->first();
    }

    public function getUnreadMessagesCount()
    {
        return $this->conversations()
            ->where('is_read', false)
            ->where('direction', 'incoming')
            ->count();
    }
}

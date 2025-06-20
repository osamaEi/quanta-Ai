<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'rating',
        'is_published',
    ];

    /**
     * Get the user that owns the testimonial.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

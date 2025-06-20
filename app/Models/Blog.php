<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Blog extends Model
{
    use HasFactory;


    protected $guarded=[];

    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}

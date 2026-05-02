<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageGeneration extends Model
{
    protected $fillable = [
        'user_id',
        'prompt',
        'image_path',
        'model',
        'credits_spent'
    ];

    /**
     * Get the URL for the generated image.
     */
    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

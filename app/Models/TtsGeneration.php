<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class TtsGeneration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'input_text',
        'model',
        'voice',
        'response_format',
        'speed',
        'audio_file_path',
        'generation_id',
        'credits_spent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAudioUrlAttribute()
    {
        if ($this->audio_file_path) {
            return Storage::disk('public')->url($this->audio_file_path);
        }
        return null;
    }
}

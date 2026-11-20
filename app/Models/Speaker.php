<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasFactory;

    protected $table = 'speakers';

    protected $fillable = [
        'name', 'email', 'expertise', 'institution', 'bio',
    ];

    public function eventSpeakers()
    {
        return $this->hasMany(EventSpeaker::class, 'speaker_id');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_speakers', 'speaker_id', 'event_id')
            ->withPivot(['syllabus_id', 'role_topic'])
            ->withTimestamps();
    }
}

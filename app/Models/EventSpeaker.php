<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSpeaker extends Model
{
    use HasFactory;

    protected $table = 'event_speakers';

    protected $fillable = [
        'event_id', 'speaker_id', 'syllabus_id', 'role_topic',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class, 'speaker_id');
    }

    public function syllabus()
    {
        return $this->belongsTo(EventSyllabus::class, 'syllabus_id');
    }
}

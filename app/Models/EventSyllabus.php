<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSyllabus extends Model
{
    use HasFactory;

    protected $table = 'event_syllabuses';

    protected $fillable = [
        'event_id', 'module_number', 'title', 'duration', 'description',
    ];

    protected $casts = [
        'module_number' => 'integer',
        'duration' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function eventSpeakers()
    {
        return $this->hasMany(EventSpeaker::class, 'syllabus_id');
    }
}

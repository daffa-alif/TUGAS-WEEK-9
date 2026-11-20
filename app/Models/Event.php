<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'event_code', 'title', 'category', 'description',
        'session_duration', 'total_sessions', 'status',
    ];

    protected $casts = [
        'session_duration' => 'integer',
        'total_sessions' => 'integer',
    ];

    public function syllabuses()
    {
        return $this->hasMany(EventSyllabus::class, 'event_id');
    }

    public function ticketTiers()
    {
        return $this->hasMany(TicketTier::class, 'event_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }

    public function eventSpeakers()
    {
        return $this->hasMany(EventSpeaker::class, 'event_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'event_speakers', 'event_id', 'speaker_id')
            ->withPivot(['syllabus_id', 'role_topic'])
            ->withTimestamps();
    }
}

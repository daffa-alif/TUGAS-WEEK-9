<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    // use HasFactory, SoftDeletes;

    protected $table = 'events';

    protected $fillable = [
        'event_code',
        'title',
        'category',
        'description',
        'session_duration',
        'total_sessions',
        'status',
    ];

    protected $casts = [
        'session_duration' => 'integer',
        'total_sessions' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Nilai default atribut model.
     */
    protected $attributes = [
        'session_duration' => 90,
        'total_sessions' => 1,
        'status' => 'Published',
    ];
}
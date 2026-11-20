<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $table = 'attendees';

    protected $fillable = [
        'full_name', 'email', 'phone', 'institution',
    ];

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'attendee_id');
    }
}

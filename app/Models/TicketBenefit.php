<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketBenefit extends Model
{
    use HasFactory;

    protected $table = 'ticket_benefits';

    protected $fillable = [
        'ticket_tier_id',
        'benefit',
    ];

    public function category()
    {
        return $this->belongsTo(TicketTier::class, 'ticket_tier_id');
    }

    public function ticketTier()
    {
        return $this->belongsTo(TicketTier::class, 'ticket_tier_id');
    }
}

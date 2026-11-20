<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketTier extends Model
{
    use HasFactory;

    protected $table = 'ticket_tiers';

    protected $fillable = [
        'event_id', 'tier_name', 'price', 'quota', 'available_seats', 'benefits',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quota' => 'integer',
        'available_seats' => 'integer',
        'benefits' => 'array',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function registrations()
    {
        return $this->hasMany(EventRegistration::class, 'ticket_tier_id');
    }

    public function ticketBenefits()
    {
        return $this->hasMany(TicketBenefit::class, 'ticket_tier_id');
    }

    public function getCodeAttribute(): string
    {
        return 'TKT-' . str_pad((string) $this->getKey(), 3, '0', STR_PAD_LEFT);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format((float) $this->price, 0, ',', '.');
    }

    public function getSisaKuotaAttribute(): int
    {
        return max(0, (int) $this->available_seats);
    }

    public function getPersenOkupansiAttribute(): int
    {
        if ((int) $this->quota <= 0) {
            return 0;
        }

        $sold = max(0, (int) $this->quota - (int) $this->available_seats);
        return min(100, (int) round(($sold / (int) $this->quota) * 100));
    }
}

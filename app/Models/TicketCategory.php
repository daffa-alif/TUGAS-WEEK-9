<?php

namespace App\Models;

/**
 * Compatibility model for the original TicketCategory model.
 * The SQL dump's canonical table/columns are ticket_tiers.
 */
class TicketCategory extends TicketTier
{
    // Inherits table, primary key, casts, accessors and relationships from TicketTier.
}

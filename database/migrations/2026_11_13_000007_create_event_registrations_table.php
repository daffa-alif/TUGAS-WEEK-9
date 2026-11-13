<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('event_registrations')) {
            return;
        }

        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('ticket_tier_id');
            $table->unsignedBigInteger('attendee_id');
            $table->string('registration_code', 50)->unique('registration_code');
            $table->string('qr_code_hash');
            $table->enum('payment_status', ['Pending', 'Paid', 'Cancelled'])->default('Paid');
            $table->enum('attendance_status', ['Belum Hadir', 'Hadir'])->default('Belum Hadir');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->foreign('event_id', 'fk_reg_event')
                ->references('id')->on('events')
                ->cascadeOnDelete();
            $table->foreign('ticket_tier_id', 'fk_reg_ticket')
                ->references('id')->on('ticket_tiers')
                ->restrictOnDelete();
            $table->foreign('attendee_id', 'fk_reg_attendee')
                ->references('id')->on('attendees')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registrations');
    }
};

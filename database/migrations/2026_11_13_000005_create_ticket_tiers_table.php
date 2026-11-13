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
        if (Schema::hasTable('ticket_tiers')) {
            return;
        }

        Schema::create('ticket_tiers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->string('tier_name', 100)->comment('VIP, Early Bird, Regular, Mahasiswa');
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('quota')->default(100);
            $table->unsignedInteger('available_seats')->default(100);
            $table->json('benefits')->nullable()->comment('Array JSON benefit tiket');
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();

            $table->foreign('event_id', 'fk_tickets_event')
                ->references('id')->on('events')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_tiers');
    }
};

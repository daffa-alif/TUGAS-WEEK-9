<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ticket_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('tier_name', 100)->comment('VIP, Early Bird, Regular, Mahasiswa');
            $table->decimal('price', 12, 2)->default(0);
            $table->unsignedInteger('quota')->default(100);
            $table->unsignedInteger('available_seats')->default(100);
            $table->json('benefits')->nullable()->comment('Array JSON benefit tiket');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_tiers');
    }
};
